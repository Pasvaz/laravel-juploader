<?php
namespace Uploader;

/**
 * Interface Builder.
 *
 * @category   HTML/UI
 * @package    Uploader
 * @author     Pasquale Vazzana - <pasqualevazzana@gmail.com>
 * @license    MIT License <http://www.opensource.org/licenses/mit>
 *
 * @see        https://github.com/blueimp/jQuery-File-Upload
 */
class ButtonBar
{
    /**
     * @var array
     */
    private $buttons = array();

    /**
     * @var boolean
     */
    private $has_progress = true;

    /**
     * @var boolean
     */
    private $has_progress_extended = true;

    /**
     * Costructor
     *
     */
    function __construct() 
    {
    	$this->buttons[Button::BUTTON_FILE] = Button::fileButton();
    	$this->buttons[Button::BUTTON_START] = Button::startButton();
    	$this->buttons[Button::BUTTON_CANCEL] = Button::cancelButton();
    	$this->buttons[Button::BUTTON_DELETE] = Button::deleteButton();
    	$this->buttons[Button::BUTTON_SELECTALL] = Button::selectallButton();
    }

    /**
     * Create a new ButtonBar instance.
     *
     * @param boolean $has_AddFiles       Display the Add Files button
     *
     * @return ButtonBar
     */
    public static function create($has_buttons = true, $has_progress = true, $has_progress_extended = true)
    {
        // Fetch current instance
        $instance = new ButtonBar;

        if ($has_buttons === false)
            $instance->delete_buttons();

        $instance->has_progress = $has_progress;
        $instance->has_progress_extended = $has_progress_extended;

        return $instance;
    }

	public function with_button($type, $button = null)
	{
		if (is_null($button) or empty($button))
			$this->buttons[$type] = Button::create($type);
		else if (is_string($button))
			$this->buttons[$type] = Button::create($type, $button);
		else if ($button instanceof Button)
			$this->buttons[$type] = $button;
		return $this;
	}

	public function delete_button($type)
	{
		unset($this->buttons[$type]);
		return $this;
	}

	public function delete_buttons()
	{
		$this->buttons = array();
		return $this;
	}

	public function __toString()
	{
		$button_bar='';
		foreach ($this->buttons as $type => $button) 
		{
			$button_bar.= $button->getHtml();
		}
			//<!-- The fileinput-button span is used to style the file input field as button -->
			$div2a = static::div_wrapper($button_bar, array('class'=>"span7"));

			$div2b = '';
			if ($this->has_progress)
			{
				$div2b_a_a = static::div_wrapper('', array('class'=>"bar", 'style'=>"width:0%;"));
				//<!-- The global progress bar -->
				$div2b_a = ($this->has_progress) 
					? static::div_wrapper($div2b_a_a, array(
						'class'=>"progress progress-success progress-striped active", 
						'role'=>"progressbar",
						'aria-valuemin'=>"0",
						'aria-valuemax'=>"100"))
					: '';
				
				$div2b_b = '';
				if ($this->has_progress_extended)
				{
					//<!-- The extended global progress information -->
					$div2b_b = ($this->has_progress_extended) 
						? static::div_wrapper('&nbsp;', array('class'=>"progress-extended"))
						: '';
				}
				//<!-- The global progress information -->
				$div2b = static::div_wrapper($div2b_a.$div2b_b, array('class'=>"span5 fileupload-progress fade"));
			}

		$main_div = static::div_wrapper($div2a.$div2b, array('class'=>"row fileupload-buttonbar"));

		//<!-- The loading indicator is shown during file processing -->
		$main_div .= static::div_wrapper('', array('class'=>"fileupload-loading"));

		//<!-- The table listing the files available for upload/download -->
		$main_div .= '<table role="presentation" class="table table-striped">'.PHP_EOL;
		$main_div .= '<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>'.PHP_EOL;
		$main_div .= '</table>'.PHP_EOL;

		return $main_div;
	}

    public static function div_wrapper($value, $attributes)
    {
    	$div = '<div'.\HTML::attributes($attributes).'>';
    	if ($value) $div .= PHP_EOL.$value.PHP_EOL;
    	$div .= '</div>'.PHP_EOL;
    	return $div;
    }
}