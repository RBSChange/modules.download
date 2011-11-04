<?php
/**
 * @package modules.download.lib.services
 */
class download_ModuleService extends ModuleBaseService
{
	/**
	 * Singleton
	 * @var download_ModuleService
	 */
	private static $instance = null;

	/**
	 * @return download_ModuleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
	
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	public function getStructureInitializationAttributes($container, $attributes, $script)
	{
		switch ($script)
		{
			case 'globalDefaultStructure':
				return $this->getGlobalStructureInitializationAttributes($container, $attributes, $script);
				
			case 'localDefaultStructure' :
				return $this->getLocalStructureInitializationAttributes($container, $attributes, $script);
			
			default:
				throw new BaseException('Unknown structure initialization script: '.$script, 'm.website.bo.actions.unknown-structure-initialization-script', array('script' => $script));
		}
	}
	
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	protected function getGlobalStructureInitializationAttributes($container, $attributes, $script)
	{
		// Check container.
		if (!$container instanceof website_persistentdocument_topic)
		{
			throw new BaseException('Invalid topic', 'm.website.bo.actions.invalid-topic');
		}
		$websiteId = $container->getDocumentService()->getWebsiteId($container);
	
		$website = DocumentHelper::getDocumentInstance($websiteId, 'modules_website/website');
		if (TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_download_documentcardalllist', $website) || 
			TagService::getInstance()->hasDocumentByContextualTag('contextual_website_website_modules_download_category', $website))
		{
			throw new BaseException('Some pages of the global structure are already initialized', 'modules.download.bo.general.Some-pages-already-initialized');
		}
		
		// Set atrtibutes.
		$attributes['byDocumentId'] = $container->getId();
		$attributes['type'] = $container->getPersistentModel()->getName();
		return $attributes;
	}
	
	/**
	 * @param f_peristentdocument_PersistentDocument $container
	 * @param array $attributes
	 * @param string $script
	 * @return array
	 */
	protected function getLocalStructureInitializationAttributes($container, $attributes, $script)
	{
		// Check container.
		if (!$container instanceof website_persistentdocument_topic)
		{
			throw new BaseException('Invalid topic', 'modules.download.bo.general.Invalid-topic');
		}
		
		$query = website_PageService::getInstance()->createQuery()->add(Restrictions::orExp(
			Restrictions::hasTag('functional_download_documentcard-list'),
			Restrictions::hasTag('functional_download_documentcard-detail')
		));
		$query->add(Restrictions::childOf($container->getId()))->setProjection(Projections::rowCount('count'));
		if (f_util_ArrayUtils::firstElement($query->findColumn('count')) > 0)
		{
			throw new BaseException('This topic already contains some of this pages', 'modules.download.bo.general.Topic-already-contains-some-of-this-pages');
		}
		
		// Set atrtibutes.
		$attributes['byDocumentId'] = $container->getId();
		$attributes['type'] = $container->getPersistentModel()->getName();
		return $attributes;
	}
}