<?php
/**
 * download_TreefolderScriptDocumentElement
 * @package modules.download.persistentdocument.import
 */
class download_TreefolderScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return download_persistentdocument_treefolder
     */
    protected function initPersistentDocument()
    {
    	return download_TreefolderService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_download/treefolder');
	}
}