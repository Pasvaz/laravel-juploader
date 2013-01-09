<?php
namespace Uploader;

class Button
{
    /**
     * Button actions
     *
     * @var constant
     */
    const BUTTON_FILE    = 'fileinput-button';
    const BUTTON_START   = 'start';
    const BUTTON_CANCEL  = 'cancel';
    const BUTTON_DELETE  = 'delete';
    const BUTTON_SELECTALL  = 'selectall';

	private $label;
	private $icon;
	private $action;
    private $class;
	private $fileInputName;

    /**
     * Costructor
     */
    function __construct($label, $icon, $btn_action='', $btn_style='', $fileInputName='files')
    {
    	$this->label = $label;
    	$this->icon = $icon;
    	$this->action = $btn_action;
    	$this->class = "btn $btn_style $btn_action";
        $this->fileInputName = $fileInputName;
    }

    public function with_label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function with_icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function with_style($btn_style)
    {
        $this->class = "btn $btn_style ".$this->action;
        return $this;
    }

    public function getHtml() { return $this->__toString(); }
	public function __toString()
	{
		$lbl_span = \HTML::span($this->label);
		
		if (is_null($this->icon) or empty($this->icon) or !is_string($this->icon))
			$icon = '';
		else if (strpos('<i', $this->icon) !== false)
			$icon = $this->icon;
		else
			$icon = '<i class="'.$this->icon.'"></i>';
        $icon .= PHP_EOL;

    	if (is_null($this->action) or !is_string($this->action))
    	{
    		$button = '';
    	}
    	else if ($this->action == static::BUTTON_FILE or $this->action == 'file')
    	{
            $input = '<input type="file" name="'.$this->fileInputName.'[]" multiple>';
            $button ='<span class="'.$this->class.'">';
            $button .=$icon.$lbl_span.$input;
			$button .='</span>';

    	}
    	else
    	{
    		if ($this->action == static::BUTTON_START)
	    		$type = 'submit';
    		else if ($this->action == static::BUTTON_CANCEL)
	    		$type = 'reset';
    		else //if ($this->action == static::BUTTON_DELETE)
	    		$type = 'button';
            $button ='<button type="'.$type.'" class="'.$this->class.'">';
            $button .=$icon.$lbl_span;
            $button .='</button>';
		}

        return $button.PHP_EOL;
	}

    static function create($type, $label = null, $icon = null, $style = null)
    {
        $button = null;
        switch($type)
        {
            case static::BUTTON_FILE:
                $button = static::fileButton();
                break;
            case static::BUTTON_START:
                $button = static::startButton();
                break;
            case static::BUTTON_CANCEL:
                $button = static::cancelButton();
                break;
            case static::BUTTON_DELETE:
                $button = static::deleteButton();
                break;
            case static::BUTTON_SELECTALL:
                $button = static::selectallButton();
                break;
            default:
                $button = new Button('', '');
        }

        if (!is_null($label) and is_string($label))
            $button = $button->with_label($label);

        if (!is_null($icon) and is_string($icon))
            $button = $button->with_icon($icon);

        if (!is_null($style) and is_string($style))
            $button = $button->with_style($style);

        return $button;
    }

    static function fileButton()
    { return new Button(__('juploader::interface.add_files'), "icon-plus icon-white", 'fileinput-button', 'btn-success'); }
	static function startButton()
	{ return new Button(__('juploader::interface.startall'), "icon-upload icon-white", 'start', 'btn-primary'); }
	static function cancelButton()
	{ return new Button(__('juploader::interface.cancelall'), "icon-ban-circle icon-white", 'cancel', 'btn-warning'); }
    static function deleteButton()
    { return new Button(__('juploader::interface.deleteall'), "icon-trash icon-white", 'delete', 'btn-danger'); }
    static function selectallButton()
    { return new Button(__('juploader::interface.selectall'), "icon-check", 'selectall', ''); }
}
