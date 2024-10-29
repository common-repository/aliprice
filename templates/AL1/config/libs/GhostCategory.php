<?php

class GhostCategory
{
	private $_id;
	private $_name;
	private $_slug;
    private $_count;
	private $_parent = 0;
    private $_tax;

	protected function update( $args )
	{
		return wp_update_term($this->getId() ,'category', $args);
	}

	protected function insert($name, $args )
	{
		return wp_insert_term($name ,'category', $args);
	}

	public function save()
	{
		if(empty($this->_slug)) {
			$this->_slug = sanitize_title($this->_name);
		}

		$args = array(			
			'name'   => $this->_name,
			'slug'   => $this->_slug,
			'parent' => $this->_parent,
		);	

		if($this->_id) {
			$success = $this->update( $args );
		} else {
			unset($args['name']);
			$success = $this->insert($this->_name, $args );
			$this->_id = $success['term_id'];
		}

		if($success) {
			return true;
		}

		return false;
	}

	public function delete()
	{
		if(wp_delete_category($this->_id)) {
			return true;
		};

		return false;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;

		return $this;
	}

    public function getTax()
    {
        return $this->_tax;
    }

    public function setTax($tax)
    {
        $this->_tax = $tax;

        return $this;
    }

	public function getName()
	{
		return $this->_name;
	}
	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}

    public function getCount()
    {
        return $this->_count;
    }
    public function setCount($count)
    {
        $this->_count = $count;

        return $this;
    }

	public function getSlug()
	{
		return $this->_slug;
	}
	public function setSlug($slug)
	{
		$this->_slug = sanitize_title($slug);

		return $this;
	}

	public function getParent()
	{
		return $this->_parent;
	}
	public function setParent($parent)
	{
		$this->_parent = $parent;

		return $this;
	}

	public function findById($id)
	{
		$result = get_term_by('id', $id, 'category');

		return $this->_parseData($result);
	}

	public function findByName($name)
	{
		$result = get_term_by('name', $name, 'category');

		return $this->_parseData($result);
	}

	public function findCategoryByName($name)
	{
		$args = array(
			'taxonomy' => $name,
		); 

		$results = get_categories($args);

		$data = array();
		if($results) {
			foreach($results as $key => $item) {
				$data[$key] = new GhostCategory();
				$data[$key]->setId($item->term_id)
						   ->setName($item->name)
						   ->setSlug($item->slug)
                           ->setCount($item->count)
						   ->setParent($item->parent)
                           ->setTax($item->taxonomy);
			}
		}

		return $data;
	}

	protected function _parseData($data)
	{
		if(!$data) { return false; }

		$this->_id = $data->term_id;
		$this->setName($data->name);
		$this->setSlug($data->slug);
		$this->setParent($data->parent);
        $this->setCount($data->count);
        $this->setTax($data->taxonomy);

		return $this;
	}
}