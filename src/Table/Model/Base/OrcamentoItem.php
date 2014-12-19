<?php

namespace Table\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Table\Model\Orcamento as ChildOrcamento;
use Table\Model\OrcamentoItemQuery as ChildOrcamentoItemQuery;
use Table\Model\OrcamentoQuery as ChildOrcamentoQuery;
use Table\Model\Produto as ChildProduto;
use Table\Model\ProdutoQuery as ChildProdutoQuery;
use Table\Model\Map\OrcamentoItemTableMap;

/**
 * Base class that represents a row from the 'orcamento_item' table.
 *
 * 
 *
* @package    propel.generator.Table.Model.Base
*/
abstract class OrcamentoItem implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Table\\Model\\Map\\OrcamentoItemTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the orcamento_id field.
     * @var        int
     */
    protected $orcamento_id;

    /**
     * The value for the produto_id field.
     * @var        int
     */
    protected $produto_id;

    /**
     * The value for the qtd field.
     * @var        int
     */
    protected $qtd;

    /**
     * The value for the valor field.
     * @var        string
     */
    protected $valor;

    /**
     * The value for the order field.
     * @var        int
     */
    protected $order;

    /**
     * @var        ChildOrcamento
     */
    protected $aOrcamento;

    /**
     * @var        ChildProduto
     */
    protected $aProduto;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Table\Model\Base\OrcamentoItem object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>OrcamentoItem</code> instance.  If
     * <code>obj</code> is an instance of <code>OrcamentoItem</code>, delegates to
     * <code>equals(OrcamentoItem)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|OrcamentoItem The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [orcamento_id] column value.
     * 
     * @return int
     */
    public function getOrcamentoId()
    {
        return $this->orcamento_id;
    }

    /**
     * Get the [produto_id] column value.
     * 
     * @return int
     */
    public function getProdutoId()
    {
        return $this->produto_id;
    }

    /**
     * Get the [qtd] column value.
     * 
     * @return int
     */
    public function getQtd()
    {
        return $this->qtd;
    }

    /**
     * Get the [valor] column value.
     * 
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Get the [order] column value.
     * 
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param  int $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [orcamento_id] column.
     * 
     * @param  int $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setOrcamentoId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->orcamento_id !== $v) {
            $this->orcamento_id = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_ORCAMENTO_ID] = true;
        }

        if ($this->aOrcamento !== null && $this->aOrcamento->getId() !== $v) {
            $this->aOrcamento = null;
        }

        return $this;
    } // setOrcamentoId()

    /**
     * Set the value of [produto_id] column.
     * 
     * @param  int $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setProdutoId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->produto_id !== $v) {
            $this->produto_id = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_PRODUTO_ID] = true;
        }

        if ($this->aProduto !== null && $this->aProduto->getId() !== $v) {
            $this->aProduto = null;
        }

        return $this;
    } // setProdutoId()

    /**
     * Set the value of [qtd] column.
     * 
     * @param  int $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setQtd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->qtd !== $v) {
            $this->qtd = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_QTD] = true;
        }

        return $this;
    } // setQtd()

    /**
     * Set the value of [valor] column.
     * 
     * @param  string $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setValor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->valor !== $v) {
            $this->valor = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_VALOR] = true;
        }

        return $this;
    } // setValor()

    /**
     * Set the value of [order] column.
     * 
     * @param  int $v new value
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[OrcamentoItemTableMap::COL_ORDER] = true;
        }

        return $this;
    } // setOrder()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OrcamentoItemTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OrcamentoItemTableMap::translateFieldName('OrcamentoId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->orcamento_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OrcamentoItemTableMap::translateFieldName('ProdutoId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->produto_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OrcamentoItemTableMap::translateFieldName('Qtd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->qtd = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OrcamentoItemTableMap::translateFieldName('Valor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->valor = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OrcamentoItemTableMap::translateFieldName('Order', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = OrcamentoItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Table\\Model\\OrcamentoItem'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aOrcamento !== null && $this->orcamento_id !== $this->aOrcamento->getId()) {
            $this->aOrcamento = null;
        }
        if ($this->aProduto !== null && $this->produto_id !== $this->aProduto->getId()) {
            $this->aProduto = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrcamentoItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOrcamentoItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOrcamento = null;
            $this->aProduto = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see OrcamentoItem::setDeleted()
     * @see OrcamentoItem::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildOrcamentoItemQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoItemTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                OrcamentoItemTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aOrcamento !== null) {
                if ($this->aOrcamento->isModified() || $this->aOrcamento->isNew()) {
                    $affectedRows += $this->aOrcamento->save($con);
                }
                $this->setOrcamento($this->aOrcamento);
            }

            if ($this->aProduto !== null) {
                if ($this->aProduto->isModified() || $this->aProduto->isNew()) {
                    $affectedRows += $this->aProduto->save($con);
                }
                $this->setProduto($this->aProduto);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[OrcamentoItemTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrcamentoItemTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ORCAMENTO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'orcamento_id';
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_PRODUTO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'produto_id';
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_QTD)) {
            $modifiedColumns[':p' . $index++]  = 'qtd';
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_VALOR)) {
            $modifiedColumns[':p' . $index++]  = 'valor';
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'order';
        }

        $sql = sprintf(
            'INSERT INTO orcamento_item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'orcamento_id':                        
                        $stmt->bindValue($identifier, $this->orcamento_id, PDO::PARAM_INT);
                        break;
                    case 'produto_id':                        
                        $stmt->bindValue($identifier, $this->produto_id, PDO::PARAM_INT);
                        break;
                    case 'qtd':                        
                        $stmt->bindValue($identifier, $this->qtd, PDO::PARAM_INT);
                        break;
                    case 'valor':                        
                        $stmt->bindValue($identifier, $this->valor, PDO::PARAM_STR);
                        break;
                    case 'order':                        
                        $stmt->bindValue($identifier, $this->order, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrcamentoItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getOrcamentoId();
                break;
            case 2:
                return $this->getProdutoId();
                break;
            case 3:
                return $this->getQtd();
                break;
            case 4:
                return $this->getValor();
                break;
            case 5:
                return $this->getOrder();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['OrcamentoItem'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['OrcamentoItem'][$this->hashCode()] = true;
        $keys = OrcamentoItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getOrcamentoId(),
            $keys[2] => $this->getProdutoId(),
            $keys[3] => $this->getQtd(),
            $keys[4] => $this->getValor(),
            $keys[5] => $this->getOrder(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aOrcamento) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'orcamento';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'orcamento';
                        break;
                    default:
                        $key = 'Orcamento';
                }
        
                $result[$key] = $this->aOrcamento->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProduto) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'produto';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'produto';
                        break;
                    default:
                        $key = 'Produto';
                }
        
                $result[$key] = $this->aProduto->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Table\Model\OrcamentoItem
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrcamentoItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Table\Model\OrcamentoItem
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setOrcamentoId($value);
                break;
            case 2:
                $this->setProdutoId($value);
                break;
            case 3:
                $this->setQtd($value);
                break;
            case 4:
                $this->setValor($value);
                break;
            case 5:
                $this->setOrder($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = OrcamentoItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setOrcamentoId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setProdutoId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setQtd($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setValor($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setOrder($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Table\Model\OrcamentoItem The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OrcamentoItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ID)) {
            $criteria->add(OrcamentoItemTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ORCAMENTO_ID)) {
            $criteria->add(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $this->orcamento_id);
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_PRODUTO_ID)) {
            $criteria->add(OrcamentoItemTableMap::COL_PRODUTO_ID, $this->produto_id);
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_QTD)) {
            $criteria->add(OrcamentoItemTableMap::COL_QTD, $this->qtd);
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_VALOR)) {
            $criteria->add(OrcamentoItemTableMap::COL_VALOR, $this->valor);
        }
        if ($this->isColumnModified(OrcamentoItemTableMap::COL_ORDER)) {
            $criteria->add(OrcamentoItemTableMap::COL_ORDER, $this->order);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildOrcamentoItemQuery::create();
        $criteria->add(OrcamentoItemTableMap::COL_ID, $this->id);
        $criteria->add(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $this->orcamento_id);
        $criteria->add(OrcamentoItemTableMap::COL_PRODUTO_ID, $this->produto_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId() &&
            null !== $this->getOrcamentoId() &&
            null !== $this->getProdutoId();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation fk_orcamento_item_orcamento1 to table orcamento
        if ($this->aOrcamento && $hash = spl_object_hash($this->aOrcamento)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation fk_orcamento_item_produto1 to table produto
        if ($this->aProduto && $hash = spl_object_hash($this->aProduto)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getOrcamentoId();
        $pks[2] = $this->getProdutoId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setOrcamentoId($keys[1]);
        $this->setProdutoId($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getOrcamentoId()) && (null === $this->getProdutoId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Table\Model\OrcamentoItem (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOrcamentoId($this->getOrcamentoId());
        $copyObj->setProdutoId($this->getProdutoId());
        $copyObj->setQtd($this->getQtd());
        $copyObj->setValor($this->getValor());
        $copyObj->setOrder($this->getOrder());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Table\Model\OrcamentoItem Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildOrcamento object.
     *
     * @param  ChildOrcamento $v
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrcamento(ChildOrcamento $v = null)
    {
        if ($v === null) {
            $this->setOrcamentoId(NULL);
        } else {
            $this->setOrcamentoId($v->getId());
        }

        $this->aOrcamento = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrcamento object, it will not be re-added.
        if ($v !== null) {
            $v->addOrcamentoItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrcamento object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildOrcamento The associated ChildOrcamento object.
     * @throws PropelException
     */
    public function getOrcamento(ConnectionInterface $con = null)
    {
        if ($this->aOrcamento === null && ($this->orcamento_id !== null)) {
            $this->aOrcamento = ChildOrcamentoQuery::create()->findPk($this->orcamento_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrcamento->addOrcamentoItems($this);
             */
        }

        return $this->aOrcamento;
    }

    /**
     * Declares an association between this object and a ChildProduto object.
     *
     * @param  ChildProduto $v
     * @return $this|\Table\Model\OrcamentoItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProduto(ChildProduto $v = null)
    {
        if ($v === null) {
            $this->setProdutoId(NULL);
        } else {
            $this->setProdutoId($v->getId());
        }

        $this->aProduto = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProduto object, it will not be re-added.
        if ($v !== null) {
            $v->addOrcamentoItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProduto object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProduto The associated ChildProduto object.
     * @throws PropelException
     */
    public function getProduto(ConnectionInterface $con = null)
    {
        if ($this->aProduto === null && ($this->produto_id !== null)) {
            $this->aProduto = ChildProdutoQuery::create()->findPk($this->produto_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduto->addOrcamentoItems($this);
             */
        }

        return $this->aProduto;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aOrcamento) {
            $this->aOrcamento->removeOrcamentoItem($this);
        }
        if (null !== $this->aProduto) {
            $this->aProduto->removeOrcamentoItem($this);
        }
        $this->id = null;
        $this->orcamento_id = null;
        $this->produto_id = null;
        $this->qtd = null;
        $this->valor = null;
        $this->order = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aOrcamento = null;
        $this->aProduto = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrcamentoItemTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}