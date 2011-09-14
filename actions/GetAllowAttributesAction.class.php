<?php
/**
 * download_GetAllowAttributesAction
 * @package modules.download.actions
 */
class download_GetAllowAttributesAction extends change_JSONAction
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		$result = array();

		$result['file'] = DocumentHelper::expandAllowAttribute('[modules_media_media]');
		$result['topic'] = DocumentHelper::expandAllowAttribute('[modules_website_topic]');
		$result['category'] = DocumentHelper::expandAllowAttribute('[modules_download_category]');

		return $this->sendJSON($result);
	}
}