<?php
/**
 * download_BlockCategoryContextualListAction
 * @package modules.download.lib.blocks
 */
class download_BlockCategoryContextualListAction extends website_BlockAction
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
		
		$topic = $this->getContext()->getParent();
		$request->setAttribute('topic', $topic);
		$categoriesInfos = download_CategoryService::getInstance()->getPublishedInfosByTopic($topic);
		if (count($categoriesInfos) > 0)
		{
			$request->setAttribute('categoriesInfos', $categoriesInfos);
		}
		
		$request->setAttribute('blockTitle', $this->getConfiguration()->getBlockTitle());

		return website_BlockView::SUCCESS;
	}
}