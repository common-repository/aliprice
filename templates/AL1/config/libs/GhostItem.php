<?php

class GhostItem
{
	private $_id;
	private $_menu;
	private $_title;
	private $_url;
	private $_parent = 0;
	private $_type   = 'custom';
	private $_page;
	private $_category;
	private $_object = 'custom';
    private $_titleattr = '';

	public function save()
	{
		$this->beforeSave();

        $type = $this->_type;

		if($type === 'custom') {
			return $this->_saveCustom();
		} elseif($type === 'page') {
			return $this->_savePage();
		} elseif($type === 'category') {
			return $this->_saveCategory();
		}

		$this->afterSave();
	}

	public function afterSave()
	{
		
	}

	public function beforeSave()
	{
		
	}

	public function delete()
	{
		if(wp_delete_post($this->_id)) {
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

	public function getObject()
	{
		return $this->_object;
	}

	public function setObject($object)
	{
		$this->_object = $object;

		return $this;
	}

    public function getType()
    {
        return $this->_type;
    }

    public function setType($type)
    {
        if($this->getObject() == 'custom' && $type == 'custom') {
            $this->_type = $type;
        } elseif($type == 'taxonomy') {
            $this->_type = 'category';
        } elseif($this->getObject() == 'page') {
            $this->_type = 'page';
        }

        return $this;
    }

	public function getTitle()
	{
		return $this->_title;
	}
	public function setTitle($title)
	{
		$this->_title = $title;

		return $this;
	}

    public function getTitleAttr()
    {
        return $this->_titleattr;
    }
    public function setTitleAttr($title)
    {
        $this->_titleattr = $title;

        return $this;
    }

	public function getUrl()
	{
		return $this->_url;
	}
	public function setUrl($url)
	{
		$this->_url = $url;

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

	public function getMenu()
	{
		return $this->_menu;
	}
	public function setMenu($menu)
	{
		$this->_menu = $menu;

		return $this;
	}

	public function setPage(GhostPages $page)
	{
		$this->_type = 'page';
		$this->_page = $page;
		
		return $this;
	}

	public function setCategory(GhostCategory $category)
	{
		$this->_type = 'category';
        $this->_object = $category->getTax();
		$this->_category = $category;

		return $this;
	}

	protected function _saveCustom()
	{
		$itemData = array(
			'menu-item-title'     => $this->_title,
	        'menu-item-url'       => home_url( $this->_url ), 
	        'menu-item-status'    => 'publish',
	        'menu-item-parent-id' => $this->_parent,
            'menu-item-attr-title'  => $this->_titleattr,
		);

		if($this->_id) { 
			$itemData['menu-item-db-id'] = $this->_id;
		}

		if($id = wp_update_nav_menu_item($this->_menu, 0, $itemData)) {
			$this->_id = $id;
			return true;
		}

		return false;
	}

	protected function _savePage()
	{
		$itemData = array(
			'menu-item-object-id'   => $this->_page->getId(),
			'menu-item-object'      => 'page',
			'menu-item-type'        => 'post_type',
			'menu-item-parent-id'   => $this->_parent,
			'menu-item-title'       => $this->_page->getTitle(),
			'menu-item-url'         => get_permalink($this->_page->getId()),
			'menu-item-status'      => 'publish',
            'menu-item-attr-title'  => $this->_titleattr,
		);

		if($this->_id) { 
			$itemData['menu-item-db-id'] = $this->_id;
		}

		if($id = wp_update_nav_menu_item($this->_menu, 0, $itemData)) {
			$this->_id = $id;
			return true;
		}

		return false;
	}

	protected function _saveCategory()
	{
		$itemData = array(
			'menu-item-parent-id'   => $this->_parent,
			'menu-item-status'      => 'publish',
			'menu-item-object-id'   => $this->_category->getId(),
			'menu-item-object'      => $this->_object,
			'menu-item-type'        => 'taxonomy',
            'menu-item-attr-title'  => $this->_titleattr,
		);

		if($this->_id) { 
			$itemData['menu-item-db-id'] = $this->_id;
		}

		if($id = wp_update_nav_menu_item($this->_menu, 0, $itemData)) {
			$this->_id = $id;
			return true;
		}

		return false;
	}

}