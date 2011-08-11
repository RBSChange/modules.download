<?php
/**
 * download_CategoryScriptDocumentElement
 * @package modules.download.persistentdocument.import
 */
class download_CategoryScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return download_persistentdocument_category
     */
    protected function initPersistentDocument()
    {
    	return download_CategoryService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_download/category');
	}
}