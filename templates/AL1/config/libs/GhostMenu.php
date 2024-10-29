<?php

class GhostMenu
{
	private $_id;
	private $_name;
	private $_items = array();

	public function afterSave()
	{
		$this->itemSave();
	}

	public function itemSave()
	{
		if(count($this->_items)) {
			foreach ($this->_items as $item) {
				$item->setMenu($this->_id)->save();
			}
		}
	}

	public function save()
	{
		if(!$this->_id) {
			if(is_nav_menu($this->getName())) {
				$result    = wp_get_nav_menu_object($this->_name);
				$this->_id = $result->term_id;
			} else {
				$result = wp_create_nav_menu($this->_name);
				$this->_id = $result;
			}
		} else {
			wp_update_term($this->_id, 'nav_menu', array(
				'name' => $this->_name,
				'slug' => sanitize_title($this->_name),
			));
		}

		if($this->_id) {
			$this->afterSave();

			return true;
		}

		return false;
	}

	public function delete()
	{
		if($this->_id > 0 && wp_delete_nav_menu($this->_id)) {
			return true;
		}

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

	public function getName()
	{
		return $this->_name;
	}
	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}

	public function addItem($items)
	{
		if(is_array($items)) {
			$this->_items = $items;
		} elseif(is_object($items)) {
			$this->_items[] = $items;
		}

		return $this;
	}

	public function getItems()
	{
		$results = wp_get_nav_menu_items($this->_id);

		$success = array();
		if(count($results)) {
			foreach($results as $item) {
                $it = new GhostItem();
                $it->setId($item->ID);
                $it->setTitle($item->post_title);
                $it->setUrl($item->guid);
                $it->setParent($item->post_parent);
                $it->setMenu($this->_id);
                $it->setObject($item->object);
                $it->setType($item->type);
                $it->setTitleAttr($item->attr_title);
                $this->addItem($it);
                $success[] = $it;
			}
		}

		return $success;
	}

	public function getItemById($id)
	{
		$results = wp_get_nav_menu_items($this->_id);

		$success = NULL;
		$test = NULL;
		if(count($results)) {
			foreach($results as $item) {
				$item->ghost_menu_id = $this->_id;
				$test = new GhostItem($item);

				if($test->getId() == $id) {
					$success = $test;
				}
			}
		}

		return $success;
	}

	public function getItemByTitle($title)
	{
		$results = wp_get_nav_menu_items($this->_id);

		$success = NULL;
		$test = NULL;
		if(count($results)) {
			foreach($results as $item) {
				$item->ghost_menu_id = $this->_id;
				$test = new GhostItem($item);

				if($test->getTitle() == $title) {
					$success = $test;
				}
			}
		}

		return $success;
	}

	public function findByName($name)
	{
		$result = wp_get_nav_menu_object($name);

		return $this->_parseData($result);
	}

	protected function _parseData($data)
	{
		$this->_id = $data->term_id;
		$this->setName($data->name);
        $this->getItems();

		return $this;
	}

}