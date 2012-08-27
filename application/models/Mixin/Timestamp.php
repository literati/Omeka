<?php 
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2012
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 */

/**
 * Mixin for models that keep added and/or modified timestamps.
 * 
 * @package Omeka
 * @subpackage Mixins
 */
class Mixin_Timestamp extends Omeka_Record_Mixin_AbstractMixin
{
    const DATE_FORMAT = 'Y-m-d h:i:s';

    protected $_record;
    protected $_addedColumn;
    protected $_modifiedColumn;

    /**
     * Initialize the mixin.
     *
     * Setting either of the column parameters to null will skip updating that
     * timestamp. The default column names are 'updated' and 'added'.
     *
     * @param Omeka_Record_AbstractRecord $record
     * @param string $addedColumn Name of the column holding the "added" timestamp.
     * @param string $updatedColumn Name of the column holding the "modified" timestamp.
     */
    public function __construct($record, $addedColumn = 'added', $modifiedColumn = 'modified')
    {
        parent::__construct($record);
        $this->_addedColumn = $addedColumn;
        $this->_modifiedColumn = $modifiedColumn;
    }
    
    /**
     * Before saving a record, set the "updated" timestamp.
     */
    public function beforeSave()
    {
        $column = $this->_modifiedColumn;
        if (!$column) {
            return;
        }

        $this->_setTimestamp($column);
    }

    /**
     * Before inserting a new record, set the "added" timestamp.
     */
    public function beforeInsert()
    {
        $column = $this->_addedColumn;
        if (!$column) {
            return;
        }

        $this->_setTimestamp($column);
    }

    /**
     * Update a timestamp column for the underlying record.
     *
     * @param string $column Column to update.
     */
    private function _setTimestamp($column)
    {
        $this->_record->$column = date(self::DATE_FORMAT);
    }
}