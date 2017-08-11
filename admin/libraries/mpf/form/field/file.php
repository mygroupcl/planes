<?php
/**
 * @package     MPF
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2016 Ossolution Team, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

class MPFFormFieldFile extends MPFFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'File';

	public function __construct($row, $value = null, $fieldSuffix = null)
	{
		parent::__construct($row, $value, $fieldSuffix);
		if ($row->size)
		{
			$this->attributes['size'] = $row->size;
		}
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 */
	protected function getInput($bootstrapHelper = null)
	{
		$html = '<input type="button" value="' . JText::_('OSM_SELECT_FILE') . '" id="button-file-' . $this->name . '" class="btn btn-primary" />';
		if ($this->value && file_exists(JPATH_ROOT . '/media/com_osmembership/upload/' . $this->value))
		{
			$html .= '<span class="osm-uploaded-file" id="uploaded-file-' . $this->name . '"><a href="index.php?option=com_osmembership&task=download_file&file_name=' . $this->value . '"><i class="icon-donwload"></i><strong>' . $this->value . '</strong></a></span>';
		}
		else
		{
			$html .= '<span class="osm-uploaded-file" id="uploaded-file-' . $this->name . '"></span>';
		}

		$html .= '<input type="hidden" name="' . $this->name . '"  value="' . $this->value . '" />';

		ob_start();
		?>
		<script language="javascript">
			new AjaxUpload('#button-file-<?php echo $this->name; ?>', {
				action: siteUrl + 'index.php?option=com_osmembership&task=upload_file',
				name: 'file',
				autoSubmit: true,
				responseType: 'json',
				onSubmit: function (file, extension) {
					jQuery('#button-file-<?php echo $this->name; ?>').after('<span class="wait">&nbsp;<img src="<?php echo JUri::root(true);?>/media/com_osmembership/ajax-loadding-animation.gif" alt="" /></span>');
					jQuery('#button-file-<?php echo $this->name; ?>').attr('disabled', true);
				},
				onComplete: function (file, json) {
					jQuery('#button-file-<?php echo $this->name; ?>').attr('disabled', false);
					jQuery('.error').remove();
					if (json['success'])
					{
						jQuery('#uploaded-file-<?php echo $this->name; ?>').html(file);
						jQuery('input[name="<?php echo $this->name; ?>"]').attr('value', json['file']);
					}
					if (json['error'])
					{
						jQuery('#button-file-<?php echo $this->name; ?>').after('<span class="error">' + json['error'] + '</span>');
					}

					jQuery('.wait').remove();
				}
			});
		</script>
		<?php
		$html .= ob_get_clean();

		return $html;
	}
}
