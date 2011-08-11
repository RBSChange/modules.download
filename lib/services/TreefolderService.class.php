<?php
/**
 * download_TreefolderService
 * @package modules.download
 */
class download_TreefolderService extends generic_FolderService
{
	/**
	 * @var download_TreefolderService
	 */
	private static $instance;

	/**
	 * @return download_TreefolderService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return download_persistentdocument_treefolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_download/treefolder');
	}

	/**
	 * Create a query based on 'modules_download/treefolder' model.
	 * Return document that are instance of modules_download/treefolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_download/treefolder');
	}
	
	/**
	 * Create a query based on 'modules_download/treefolder' model.
	 * Only documents that are strictly instance of modules_download/treefolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_download/treefolder', false);
	}
	
	/**
	 * @param download_persistentdocument_treefolder $document
	 * @return string[]
	 */
	public function getDocumentsModelNamesForTweet($document)
	{
		return array('modules_download/documentcard');
	}
	
	/**
	 * @param download_persistentdocument_treefolder $document
	 * @return boolean
	 */
	public function canSendTweetOnContainedDocumentPublish($document)
	{
		return true;
	}
	
	/**
	 * @param download_persistentdocument_treefolder $document
	 * @param string $modelName
	 * @return integer[]
	 */
	public function getContainedIdsForTweet($document, $modelName)
	{
		$query = download_DocumentcardService::getInstance()->createQuery()->add(Restrictions::published());
		$query->add(Restrictions::descendentOf($document->getId()))->setProjection(Projections::property('id'));
		return $query->findColumn('id');
	}
	
	/**
	 * @param download_persistentdocument_treefolder $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return website_WebsiteService::getInstance()->createQuery()->add(Restrictions::published())->find();
	}
}