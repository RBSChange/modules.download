<?php
/**
 * download_BlockDocumentcardContextualListAction
 * @package modules.download.lib.blocks
 */
class download_BlockDocumentcardContextualListAction extends download_BlockAbstractDocumentcardListAction
{
	/**
	 * @param f_mvc_Request $request
	 * @return f_peristentdocument_PersistentDocument 
	 */
	protected function getParentDoc($request)
	{
		return $this->getContext()->getParent();
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
			$doc = $this->getParentDoc($request);
			$title = LocaleService::getInstance()->transFO('m.download.fo.topic-title', array('ucf', 'html'), array('topic' => $doc->getLabel()));
		}
		return $title;
	}
}