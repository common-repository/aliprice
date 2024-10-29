<?php

class GhostOptions
{
	private $_name;
	private $_value;

	public function save()
	{
		if(update_option($this->_name, $this->_value)) {
			return true;
		}

		return false;
	}

	public function delete()
	{
		if(delete_option($this->_name)) {
			return true;
		}

		return false;
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

	public function getValue()
	{
		return $this->_value;
	}
	public function setValue($value)
	{
		$this->_value = $value;

		return $this;
	}

	public function findByName($name)
	{
		$value = get_option( $name );

		$args = array('name' => $name, 'value' => $value);

		return $this->_parseData($args);
	}

	protected function _parseData($data)
	{
		$this->setName($data['name']);
		$this->setValue($data['value']);

		return $this;
	}
}