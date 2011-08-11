<?php
/**
 * download_ImportMediasAction
 * @package modules.download.actions
 */
class download_ImportMediasAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$result = array();

		$parentId = $request->getParameter('parentref');
		$mediaIds = $request->getParameter('mediaIds');
		$topicIds = $request->getParameter('topicIds');
		if (!is_array($topicIds))
		{
			$topicIds = array();
		}
		$categoryIds = $request->getParameter('categoryIds');
		if (!is_array($categoryIds))
		{
			$categoryIds = array();
		}
		download_DocumentcardService::getInstance()->importMedias($parentId, $mediaIds, $topicIds, $categoryIds);
		
		return $this->sendJSON($result);
	}
}