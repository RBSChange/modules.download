<?php
/**
 * download_BlockDocumentcardAction
 * @package modules.download.lib.blocks
 */
class download_BlockDocumentcardAction extends website_BlockAction
{
	/**
	 * @param f_mvc_Request $request
	 * @param f_mvc_Response $response
	 * @return String
	 */
	public function execute($request, $response)
	{
		if ($this->isInBackofficeEdition())
		{
			return website_BlockView::NONE;
		}
	
		$context = $this->getPage();
		$isOnDetailPage = TagService::getInstance()->hasTag($context->getPersistentPage(), 'functional_download_documentcard-detail');
		$doc = $this->getDocumentParameter();
		if (!($doc instanceof download_persistentdocument_documentcard) || !$doc->isPublished())
		{
			if ($isOnDetailPage && !$this->isInBackofficePreview())
			{
				HttpController::getInstance()->redirect("website", "Error404");
			}
			return website_BlockView::NONE;
		}
		else if ($isOnDetailPage)
		{
			$this->getContext()->addCanonicalParam('topicId', null, 'download');
		}
		$config = $this->getConfiguration();
		$request->setAttribute('doc', $this->getDocumentParameter());
		$request->setAttribute('cmpref', $doc->getId());
		$request->setAttribute('isOnDetailPage', $isOnDetailPage);
		$request->setAttribute('displayConfig', $this->getDisplayConfig($request, $doc));
		$request->setAttribute('navigationPosition', $config->getNavigationPosition());
		$request->setAttribute('linkToTopic', $config->getLinkToTopic());
		$request->setAttribute('linkToAll', $config->getLinkToAll());
		
		
		$displayMode = $config->getDisplayMode();
		return $displayMode ? $displayMode : website_BlockView::SUCCESS;
	}
	
	/**
	 * @param f_mvc_Request $request
	 * @param f_persistentdocument_PersistentDocument $doc
	 * @return array
	 */
	protected function getDisplayConfig($request, $doc)
	{
		return array();
	}
	
	/**
	 * @return array<String, String>
	 */
	public function getMetas()
	{
		$doc = $this->getDocumentParameter();
		if ($doc instanceof download_persistentdocument_documentcard && $doc->isPublished())
		{
			return array(
				'label' => $doc->getLabel(), 
				'description' => f_util_StringUtils::htmlToText($doc->getDescription())
			);
		}
		return array();
	}
}