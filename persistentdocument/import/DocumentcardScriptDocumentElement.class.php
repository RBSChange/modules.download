<?php
/**
 * download_DocumentcardScriptDocumentElement
 * @package modules.download.persistentdocument.import
 */
class download_DocumentcardScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return download_persistentdocument_documentcard
     */
    protected function initPersistentDocument()
    {
    	return download_DocumentcardService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_download/documentcard');
	}
}