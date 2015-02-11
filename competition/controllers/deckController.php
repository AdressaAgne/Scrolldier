<?php 
class Deck extends Database {
	
	private function ago($datetime, $full=false)
	{
	   	   $now = new DateTime;
	       $ago = new DateTime($datetime);
	       $diff = $now->diff($ago);
	   
	       $diff->w = floor($diff->d / 7);
	       $diff->d -= $diff->w * 7;
	   
	       $string = array(
	           'y' => 'year',
	           'm' => 'month',
	           'w' => 'week',
	           'd' => 'day',
	           'h' => 'hour',
	           'i' => 'minute',
	           's' => 'second',
	       );
	       foreach ($string as $k => &$v) {
	           if ($diff->$k) {
	               $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	           } else {
	               unset($string[$k]);
	           }
	       }
	   
	       if (!$full) $string = array_slice($string, 0, 1);
	       return $string ? implode(', ', $string) : 'just now';
	 }
	
	public function setDeckImage($image, $deck) {
		
		$query = $this->_db->prepare("UPDATE decks SET image=:img WHERE id=:id");
		$arr = array(
		    'id' => $deck,
		    'img' => $image
		);
		$this->arrayBinder($query, $arr);
		
		try {
			return $query->execute();
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	public function totalDecks() {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks");
		
		try {
			$query->execute();
			return $query->rowCount();
			
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	public function get_top_decks() {
		
		
		$query = $this->_db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND competative = 1 AND vote > 3
							   ORDER BY meta DESC, vote DESC,
							   time DESC LIMIT 6");
		
		try {
			$query->execute();
			return $query->fetch(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			return $e;
		}
		
	}
	
	public function vote_up($id) {
		
		
		
	}
	
	public function vote_down($id) {
		
		
	}
	
	/**
	 * Retrieves the faction of a scroll
	 * @param array $scroll
	 * @return string Returns the faction of the scroll
	 */
	function getFaction($scroll)
	{
		if ($scroll['costgrowth'] > 0)
		{
			return 'growth';
		}
		elseif ($scroll['costorder'] > 0)
		{
			return 'order';
		}
		elseif ($scroll['costenergy'] > 0)
		{
			return 'energy';
		}
		elseif ($scroll['costdecay'] > 0)
		{
			return 'decay';
		}
	}
	
	/**
	 * Gets the cost of the scroll stack
	 * @param Scroll $scroll
	 * @return int The total price of the stack
	 */
	function getStackCost($scroll)
	{
		$cost = 100;
		if ($scroll->rarity == 1)
		{
			$cost = 500;
		}
		elseif ($scroll->rarity == 2)
		{
			$cost = 1000;
		}
		return $cost * $scroll->count;
	}
	
	
	/**
	 * Retrieves a deck
	 * @param int $id The ID of the deck to retrieve
	 * @return DeckData|boolean Returns a deck if the specified ID exists, FALSE otherwise
	 */
	public function get_deck_data($id)
	{
		// Get deck from database
		$query = $this->_db->prepare("SELECT * FROM decks WHERE id = :id");
		$arr = array(
		    'id' => $id
		);
		$this->arrayBinderInt($query, $arr);
		$query->execute();	
		$data = $query->fetch(PDO::FETCH_ASSOC);
		
		// Check deck exists
		if (empty($data))
		{
			return FALSE;
		}
		
		$json = json_decode($data['JSON'], TRUE);
		
		// Set metadata
		$deck_data = new DeckData();
		$deck_data->id           = $id;
		$deck_data->name         = $data['deck_title'];
		$deck_data->author       = $data['deck_author'];
		$deck_data->text         = $data['text'];
		$deck_data->meta_version = $data['meta'];
		$deck_data->time         = $this->ago($data['time']) . ' ago';
		$deck_data->vote_up      = $data['vote'];
		$deck_data->vote_down    = $data['vote_down'];
		
		$deck_data->export['deck'] = $data['deck_title'];
		$deck_data->export['author'] = "contest submission";
		
		if (!empty($data['tags'])) {
			$deck_data->tags 		 = explode(',',$data['tags']);
		}
		
		
		
		// Parse scroll IDs
		$scroll_ids = [];
		$scrolls_count = [];
		foreach ($json['data']['scrolls'] as $scroll)
		{
			$scroll_ids[] = $scroll['id'];
			$scrolls_count[$scroll['id']] = $scroll['c'];
		}
		
		
		
		// Retrieve scrolls
		$prepare = implode(',', array_fill(0, count($scroll_ids), '?'));
		$query = $this->_db->prepare("SELECT * FROM scrollsCard WHERE id IN ($prepare)");
		$query->execute($scroll_ids);
		
		// Populate deck with scrolls
		$scrolls_data = $query->fetchAll();
		$total = 0;
		foreach ($scrolls_data as $scroll_data)
		{
			$scroll          = new Scroll();
			$scroll->id      = $scroll_data['id'];
			$scroll->name    = $scroll_data['name'];
			$scroll->count   = $scrolls_count[$scroll->id];
			$scroll->rarity  = $scroll_data['rarity'];
			$scroll->faction = $this->getFaction($scroll_data);
			$scroll->image   = $scroll_data['image'];
			
			$faction = $scroll->faction;
			$cost = $scroll_data["cost$faction"];
			$kind = $scroll_data['kind'];
			
			$deck_data->scrolls[]     = $scroll;
			$deck_data->scroll_count += $scroll->count;
			
			$deck_data->set[$scroll_data['scrollsSet']] += $scroll->count;
			
			$deck_data->total_cost   += $this->getStackCost($scroll);
			
			$deck_data->addKind($kind, $scroll->count);
			$deck_data->addRarity($scroll->rarity, $scroll->count);
			$deck_data->addResource($faction, $scroll->count);
			
			$deck_data->addScrollToExport($scroll->id, $scroll->count);
			
			$types = explode(',',$scroll_data['types']);
			foreach ($types as $type)
			{
				if ($type === '')
				{
					$type = 'None';
				}
				$deck_data->addType($type, $scroll->count);
			}
			
			$deck_data->addCurve($faction, 'all', $cost, $scroll->count);
			$deck_data->addCurve($faction, $kind, $cost, $scroll->count);
			
			$total += $scroll->count;
		}
		
		// Sort deck fields
		ksort($deck_data->curve);
		ksort($deck_data->set);
		arsort($deck_data->types);
		
		// Calculate faction percentage
		foreach ($deck_data->resources as $faction => $count)
		{
			if ($count > 0)
			{
				$deck_data->percentage[$faction] = $count * 100 / $total;
			}
		}
		
		
		arsort($deck_data->percentage);
		$most_used = array_keys($deck_data->percentage);
		$rand      = rand(1,4);
		$deckImage = $most_used[0] . "-$rand.jpg";
		$deck_data->faction = $most_used[0];
		
		if (empty($data['image'])) {
			// Set image from most used faction		
			if ($this->setDeckImage($deckImage, $id)) {
				$deck_data->image = $deckImage;
			} else {
				$deck_data->image = "error.jpg";
			}
			
		} else {
			$deck_data->image = $data['image'];
		}
		
		
		
		$deck_data->export = json_encode($deck_data->export);
		
		return $deck_data;
	}
	
	
}

/**
 * A deck containing multiple scrolls
 */
class DeckData
{
	public $id = 0;

	public $name = '';

	public $author = '';

	public $text = '';

	public $meta_version = '';

	public $image = '';

	public $time = '';
	
	public $faction = '';

	public $percentage = [];
	
	public $scroll_count = 0;

	public $total_cost = 0;

	public $vote_up = 0;

	public $vote_down = 0;
	

	public $kinds = array(
	    'CREATURE'    => 0,
	    'ENCHANTMENT' => 0,
	    'SPELL'       => 0,
	    'STRUCTURE'   => 0
	);

	public $types = [];

	public $rarities = array(
	    0 => 0,
	    1 => 0,
	    2 => 0
	);
	
	public $set = array(
	   1 => 0,
	   2 => 0,
	   3 => 0,
	   4 => 0,
	   5 => 0,
	   6 => 0
	);

	public $resources = [];
	
	
	public $tags = [];
	
	public $curve = array(
	    'growth' => [],
	    'order'  => [],
	    'energy' => [],
	    'decay'  => []
	);

	public $scrolls = [];
	
	
	public $export = [
		'deck' => '',
		'author' => '',
		'types' => []
	];
	
	
	public function addScrollToExport($id, $count)
	{
		for ($i = 0; $i < $count; $i++) {
			array_push($this->export['types'], $id);
		}
	}
	
	public function addType($type, $count)
	{
		if( ! isset($this->types[$type]) )
		{
			$this->types[$type] = 0;
		}
		$this->types[$type] += $count;
	}

	public function addKind($kind, $count)
	{
		if( ! isset($this->kinds[$kind]) )
		{
			$this->kinds[$kind] = 0;
		}
		$this->kinds[$kind] += $count;
	}
	
	public function addRarity($rarity, $count)
	{
		if( ! isset($this->rarities[$rarity]) )
		{
			$this->rarities[$rarity] = 0;
		}
		$this->rarities[$rarity] += $count;
	}
	
	public function addResource($resource, $count)
	{
		if( ! isset($this->resources[$resource]) )
		{
			$this->resources[$resource] = 0;
		}
		$this->resources[$resource] += $count;
	}

	public function initCurve($faction, $kind)
	{
		if (isset($this->curve[$faction][$kind]))
		{
			return;
		}
		for ($i=1; $i < 10; $i++)
		{
			$this->curve[$faction][$kind][$i] = 0;
		}
	}
	
	/**
	 * 
	 * @param string $faction
	 * @param string $kind
	 * @param int $cost
	 * @param int $count
	 */
	public function addCurve($faction, $kind, $cost, $count)
	{
		$this->initCurve($faction, $kind);
		$this->curve[$faction][$kind][$cost] += $count;
	}
	
	/**
	 * Supresses warnings about non-object<br>
	 * Unsure why this only happens with view-deck.php
	 */
	public function supressWarnings() {}
}

/**
 * Scroll with extra metadata
 */
class Scroll
{
	/**
	 * The ID of the scroll
	 * @var int
	 */
	public $id = 0;
	/**
	 * The name of the scroll
	 * @var string
	 */
	public $name = '';
	/**
	 * The amount of times the scroll appears in a deck
	 * @var id
	 */
	public $count = 0;
	/**
	 * The rarity level of the scroll.<br>
	 * 0:  100g<br>
	 * 1:  500g<br>
	 * 2: 1000g
	 * @var int
	 */
	public $rarity = 0;
	/**
	 * The faction name of the scroll
	 * @var string
	 */
	public $faction = '';
	/**
	 * The image name
	 * @var string 
	 */
	public $image = '';
}

