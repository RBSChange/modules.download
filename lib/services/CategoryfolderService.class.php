<?php
/**
 * download_CategoryfolderService
 * @package modules.download
 */
class download_CategoryfolderService extends generic_FolderService
{
	/**
	 * @var download_CategoryfolderService
	 */
	private static $instance;

	/**
	 * @return download_CategoryfolderService
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
	 * @return download_persistentdocument_categoryfolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_download/categoryfolder');
	}

	/**
	 * Create a query based on 'modules_download/categoryfolder' model.
	 * Return document that are instance of modules_download/categoryfolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_download/categoryfolder');
	}
	
	/**
	 * Create a query based on 'modules_download/categoryfolder' model.
	 * Only documents that are strictly instance of modules_download/categoryfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_download/categoryfolder', false);
	}
}