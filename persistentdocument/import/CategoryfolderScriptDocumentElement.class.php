<?php
/**
 * download_CategoryfolderScriptDocumentElement
 * @package modules.download.persistentdocument.import
 */
class download_CategoryfolderScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return download_persistentdocument_categoryfolder
     */
    protected function initPersistentDocument()
    {
    	return download_CategoryfolderService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_download/categoryfolder');
	}
}