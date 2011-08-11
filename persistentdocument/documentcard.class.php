<?php
/**
 * Class where to put your custom methods for document download_persistentdocument_documentcard
 * @package modules.download.persistentdocument
 */
class download_persistentdocument_documentcard extends download_persistentdocument_documentcardbase implements indexer_IndexableDocument
{
	/**
	 * Get the indexable document
	 *
	 * @return indexer_IndexedDocument
	 */
	public function getIndexedDocument()
	{
		$indexedDoc = new indexer_IndexedDocument();
		// TODO : set the different properties you want in you indexedDocument :
		// - please verify that id, documentModel, label and lang are correct according your requirements
		// - please set text value.
		$indexedDoc->setId($this->getId());
		$indexedDoc->setDocumentModel('modules_download/documentcard');
		$indexedDoc->setLabel($this->getLabel());
		$indexedDoc->setLang(RequestContext::getInstance()->getLang());
		$indexedDoc->setText(null); // TODO : please fill text property
		return $indexedDoc;
	}
	
}