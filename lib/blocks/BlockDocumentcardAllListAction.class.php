<?php
/**
 * download_BlockDocumentcardAllListAction
 * @package modules.download.lib.blocks
 */
class download_BlockDocumentcardAllListAction extends download_BlockAbstractDocumentcardListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return website_WebsiteModuleService::getInstance()->getCurrentWebsite();
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return string
	 */
	protected function getBlockTitle($request)
	{
		$title = $this->getConfigurationValue('blockTitle');
		if (!$title)
		{
			$title = LocaleService::getInstance()->transFO('m.download.fo.documentcards-from-website-title', array('ucf'));
		}
		return $title;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @return boolean 
	 */
	protected function isOnDetailPage($request)
	{
		$tag = 'contextual_website_website_modules_download_documentcardalllist';
		return TagService::getInstance()->hasTag($this->getContext()->getPersistentPage(), $tag);
	}
}