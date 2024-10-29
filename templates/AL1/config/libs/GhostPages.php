<?php

class GhostPages
{
	private $_id;
	private $_title;
	private $_content;
	private $_parent = 0;
	private $_post_type = 'page';

	public function getType()
	{
		return $this->_post_type;
	}
	public function setType($type)
	{
		$this->_post_type = $type;

		return $this;
	}

	public function save()
	{
		global $user_ID;

		$args = array(
			'post_type'    => $this->getType(),
			'post_parent'  => $this->_parent,
			'post_author'  => $user_ID,
			'post_status'  => 'publish',
			'post_title'   => $this->_title,
			'post_content' => $this->_content,
			'post_name'    => sanitize_title($this->_title),
		);

		if($this->_id) {
			$args['ID'] = $this->_id;

			$result = wp_update_post( $args );
		} else {
			$result = wp_insert_post( $args );
			$this->_id = $result;
		}

		if($result) {			
			return true;
		}

		return false;
	}

	public function delete()
	{
		if(wp_delete_post($this->_id)) {
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

	public function getTitle()
	{
		return $this->_title;
	}
	public function setTitle($title)
	{
		$this->_title = $title;

		return $this;
	}

	public function getContent()
	{
		return $this->_content;
	}
	public function setContent($content)
	{
		$this->_content = $content;

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

	public function isPageByTitle($title)
	{
		if(get_page_by_title($title, 'OBJECT', $this->getType())) {
			return true;
		}

		return false;
	}

	public function findById($id)
	{
		$result = get_post($id);

		return $this->_parseData($result);
	}

	public function findByTitle($title)
	{
		$result = get_page_by_title($title, 'OBJECT', $this->getType());

		return $this->_parseData($result);
	}

	protected function _parseData($data)
	{
		$this->setId($data->ID);
		$this->setTitle($data->post_title);
		$this->setContent($data->post_content);
		$this->setParent($data->post_parent);

		return $this;
	}
}