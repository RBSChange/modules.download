<?php
/**
 * download_DocumentcardService
 * @package modules.download
 */
class download_DocumentcardService extends f_persistentdocument_DocumentService
{
	/**
	 * @var download_DocumentcardService
	 */
	private static $instance;

	/**
	 * @return download_DocumentcardService
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
	 * @return download_persistentdocument_documentcard
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_download/documentcard');
	}

	/**
	 * Create a query based on 'modules_download/documentcard' model.
	 * Return document that are instance of modules_download/documentcard,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_download/documentcard');
	}
	
	/**
	 * Create a query based on 'modules_download/documentcard' model.
	 * Only documents that are strictly instance of modules_download/documentcard
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_download/documentcard', false);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @return integer
	 */
	public function getPublishedCountAnywhere()
	{
		return $this->findPublishedCount($this->createQuery());
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @return download_persistentdocument_documentcard[]
	 */
	public function getPublishedAnywhere($offset, $limit)
	{
		return $this->findPublished($this->createQuery(), $offset, $limit);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @return integer
	 */
	public function getPublishedCountByWebsite($website)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		return $this->findPublishedCount($query);
	}
	
	/**
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @return download_persistentdocument_documentcard[]
	 */
	public function getPublishedByWebsite($website, $offset, $limit)
	{
		$query = $this->createQuery()->add(Restrictions::eq('website', $website));
		return $this->findPublished($query, $offset, $limit);
	}
	
	/**
	 * @param website_persistentdocument_topic $topic
	 * @return integer
	 */
	public function getPublishedCountByTopic($topic)
	{
		$query = $this->createQuery()->add(Restrictions::eq('topic', $topic));
		return $this->findPublishedCount($query);
	}
	
	/**
	 * @param website_persistentdocument_topic $topic
	 * @param integer $offset
	 * @param integer $limit
	 * @return download_persistentdocument_documentcard[]
	 */
	public function getPublishedByTopic($topic, $offset, $limit)
	{
		$query = $this->createQuery()->add(Restrictions::eq('topic', $topic));
		return $this->findPublished($query, $offset, $limit);
	}
		
	/**
	 * @param download_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @return integer
	 */
	public function getPublishedCountByCategoryAndWebsite($category, $website)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('website', $website));
		return $this->findPublishedCount($query);
	}
	
	/**
	 * @param download_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @return download_persistentdocument_documentcard[]
	 */
	public function getPublishedByCategoryAndWebsite($category, $website, $offset, $limit)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('website', $website));
		return $this->findPublished($query, $offset, $limit);
	}
		
	/**
	 * @param download_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @return integer
	 */
	public function getPublishedCountByCategoryAndTopic($category, $topic)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('topic', $topic));
		return $this->findPublishedCount($query);
	}
	
	/**
	 * @param download_persistentdocument_category $category
	 * @param website_persistentdocument_website $website
	 * @param integer $offset
	 * @param integer $limit
	 * @return download_persistentdocument_documentcard[]
	 */
	public function getPublishedByCategoryAndTopic($category, $topic, $offset, $limit)
	{
		$query = $this->createQuery()->add(Restrictions::eq('category', $category))->add(Restrictions::eq('topic', $topic));
		return $this->findPublished($query, $offset, $limit);
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @return integer
	 */
	protected function findPublishedCount($query)
	{
		$query = $this->completeQueryForPublished($query);
		$query->setProjection(Projections::rowCount('count'));
		return f_util_ArrayUtils::firstElement($query->findColumn('count'));
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @param integer $offset
	 * @param $limit $offset
	 * @return download_persistentdocument_documentcard[]
	 */
	protected function findPublished($query, $offset, $limit)
	{
		$query = $this->completeQueryForPublished($query)->addOrder(Order::asc('label'));
		$query->setFirstResult($offset)->setMaxResults($limit);
		return $query->find();
	}
	
	/**
	 * @param f_persistentdocument_criteria_Query $query
	 * @return f_persistentdocument_criteria_Query
	 */
	protected function completeQueryForPublished($query)
	{
		$query->add(Restrictions::published())->add(Restrictions::isNotEmpty('website'));
		return $query;
	}
	
	/**
	 * @param integer $parent
	 * @param integer[] $mediaIds
	 * @param integer[] $topicIds
	 * @param integer[] $categoryIds
	 */
	public function importMedias($parentId, $mediaIds, $topicIds, $categoryIds)
	{
		$topics = array();
		foreach ($topicIds as $topicId)
		{
			$topics[] = website_persistentdocument_topic::getInstanceById($topicId);
		}
		
		$categories = array();
		foreach ($categoryIds as $categoryId)
		{
			$categories[] = download_persistentdocument_category::getInstanceById($categoryId);
		}
		
		foreach ($mediaIds as $mediaId)
		{
			$media = media_persistentdocument_media::getInstanceById($mediaId);
			$doc = $this->getNewDocumentInstance();
			$doc->setLabel($media->getTitle() ? $media->getTitle() : $media->getLabel());
			$doc->setFile($media);
			if ($media->getMediatype() == MediaHelper::TYPE_IMAGE)
			{
				$doc->setVisual($media);
			}
			if ($media->getDescription())
			{
				$doc->setDescription($media->getDescription());
			}
			$doc->setTopicArray($topics);
			$doc->setCategoryArray($categories);
			$doc->save($parentId);
		}
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		if ($document->isPropertyModified('topic'))
		{
			$this->refreshWebsites($document);
		}
	}
		
	/**
	 * @param download_persistentdocument_documentcard $document
	 */
	public function refreshWebsites($document)
	{
		$websiteIds = array();
		foreach ($document->getTopicArray() as $topic)
		{
			$websiteIds[] = $topic->getDocumentService()->getWebsiteId($topic);
		}
		$websites = website_WebsiteService::getInstance()->createQuery()->add(Restrictions::in('id', $websiteIds))->find();
		$document->setWebsiteArray($websites);
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @return integer | null
	 */
	public function getWebsiteId($document)
	{
		$website = $document->getWebsite(0);
		return ($website !== null) ? $website->getId() : null;
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @return integer[] | null
	 */
	public function getWebsiteIds($document)
	{
		$websites = $document->getWebsiteArray();
		return DocumentHelper::getIdArrayFromDocumentArray($websites);
	}

	/**
	 * @param download_persistentdocument_documentcard $document
	 * @param website_persistentdocument_website $website
	 */
	public function getPrimaryTopicForWebsite($document, $website)
	{
		$topics = $document->getPublishedTopicArray();
		$topicIds = DocumentHelper::getIdArrayFromDocumentArray($topics);
				
		$query = website_TopicService::getInstance()->createQuery()->add(Restrictions::descendentOf($website->getId()));
		$query->add(Restrictions::published())->add(Restrictions::in('id', $topicIds))->setProjection(Projections::property('id'));
		$ids = $query->findColumn('id');
		
		foreach ($topics as $topic)
		{
			if (in_array($topic->getId(), $ids))
			{
				return $topic;
			}
		}
		return null;
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @return website_persistentdocument_page | null
	 */
	public function getDisplayPage($document)
	{
		$request = change_Controller::getInstance()->getContext()->getRequest();
		if ($request->hasModuleParameter('documentcard', 'topicId'))
		{
			$topicId = $request->getModuleParameter('documentcard', 'topicId');
		}
		else
		{
			$topic = $this->getPrimaryTopicForWebsite($document, website_WebsiteModuleService::getInstance()->getCurrentWebsite());
			$topicId = $topic ? $topic->getId() : null;
		}
		
		if ($topicId > 0)
		{
			return website_PageService::getInstance()->createQuery()
				->add(Restrictions::published())
				->add(Restrictions::childOf($topicId))
				->add(Restrictions::hasTag('functional_download_documentcard-detail'))
				->findUnique();
		}
		return null;
	}

	/**
	 * @param download_persistentdocument_documentcard $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections = null)
	{
		$resume = parent::getResume($document, $forModuleName, $allowedSections);
		
		$rc = RequestContext::getInstance();
		$media = $document->getFile();
		$lang = ($media->isContextLangAvailable()) ? $rc->getLang() : $media->getLang();
		try 
		{
			$rc->beginI18nWork($lang);
			
			$image = '';
			if ($media->getMediatype() == MediaHelper::TYPE_IMAGE)
			{
				$image = LinkHelper::getDocumentUrl($media, $lang, array('max-height' => 128, 'max-width' => 128));
			}
			
			$info = $media->getInfo();
			$resume['content'] = array(
				'mimetype' => $media->getMimetype(),
				'size' => $info['size'],
				'previewimgurl' => array('id' => $media->getId(), 'lang' => $lang, 'image' => $image)
			);
			
			$rc->endI18nWork();
		}
		catch (Exception $e)
		{
			$rc->endI18nWork($e);
		}
		
		return $resume;
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @param integer $websiteId
	 * @return array
	 */
	public function getReplacementsForTweet($document, $websiteId)
	{
		$label = array(
			'name' => 'label',
			'label' => LocaleService::getInstance()->transBO('m.download.document.documentcard.label', array('ucf')),
			'maxLength' => 80
		);
		$shortUrl = array(
			'name' => 'shortUrl', 
			'label' => LocaleService::getInstance()->transBO('m.twitterconnect.bo.general.short-url', array('ucf')),
			'maxLength' => 30
		);
		if ($document !== null)
		{
			$website = website_persistentdocument_website::getInstanceById($websiteId);
			$label['value'] = f_util_StringUtils::shortenString($document->getLabel(), 80);
			$shortUrl['value'] = website_ShortenUrlService::getInstance()->shortenUrl(LinkHelper::getDocumentUrlForWebsite($document, $website));
		}
		return array($label, $shortUrl);
	}

	/**
	 * @param download_persistentdocument_documentcard $document
	 * @return f_persistentdocument_PersistentDocument[]
	 */
	public function getContainersForTweets($document)
	{
		$containers = $document->getCategoryArray();
		$containers[] = $this->getParentOf($document);
		return $containers;
	}
	
	/**
	 * @param download_persistentdocument_documentcard $document
	 * @return website_persistentdocument_website[]
	 */
	public function getWebsitesForTweets($document)
	{
		return $document->getPublishedWebsiteArray();
	}
}