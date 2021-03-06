<?php

namespace Table\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Table\Model\Orcamento as ChildOrcamento;
use Table\Model\OrcamentoQuery as ChildOrcamentoQuery;
use Table\Model\Map\OrcamentoTableMap;

/**
 * Base class that represents a query for the 'orcamento' table.
 *
 * 
 *
 * @method     ChildOrcamentoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrcamentoQuery orderByPrazo($order = Criteria::ASC) Order by the prazo column
 * @method     ChildOrcamentoQuery orderByDataInicio($order = Criteria::ASC) Order by the data_inicio column
 * @method     ChildOrcamentoQuery orderByDataFim($order = Criteria::ASC) Order by the data_fim column
 *
 * @method     ChildOrcamentoQuery groupById() Group by the id column
 * @method     ChildOrcamentoQuery groupByPrazo() Group by the prazo column
 * @method     ChildOrcamentoQuery groupByDataInicio() Group by the data_inicio column
 * @method     ChildOrcamentoQuery groupByDataFim() Group by the data_fim column
 *
 * @method     ChildOrcamentoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrcamentoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrcamentoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrcamentoQuery leftJoinOrcamentoItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrcamentoItem relation
 * @method     ChildOrcamentoQuery rightJoinOrcamentoItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrcamentoItem relation
 * @method     ChildOrcamentoQuery innerJoinOrcamentoItem($relationAlias = null) Adds a INNER JOIN clause to the query using the OrcamentoItem relation
 *
 * @method     \Table\Model\OrcamentoItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrcamento findOne(ConnectionInterface $con = null) Return the first ChildOrcamento matching the query
 * @method     ChildOrcamento findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrcamento matching the query, or a new ChildOrcamento object populated from the query conditions when no match is found
 *
 * @method     ChildOrcamento findOneById(int $id) Return the first ChildOrcamento filtered by the id column
 * @method     ChildOrcamento findOneByPrazo(int $prazo) Return the first ChildOrcamento filtered by the prazo column
 * @method     ChildOrcamento findOneByDataInicio(string $data_inicio) Return the first ChildOrcamento filtered by the data_inicio column
 * @method     ChildOrcamento findOneByDataFim(string $data_fim) Return the first ChildOrcamento filtered by the data_fim column
 *
 * @method     ChildOrcamento[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOrcamento objects based on current ModelCriteria
 * @method     ChildOrcamento[]|ObjectCollection findById(int $id) Return ChildOrcamento objects filtered by the id column
 * @method     ChildOrcamento[]|ObjectCollection findByPrazo(int $prazo) Return ChildOrcamento objects filtered by the prazo column
 * @method     ChildOrcamento[]|ObjectCollection findByDataInicio(string $data_inicio) Return ChildOrcamento objects filtered by the data_inicio column
 * @method     ChildOrcamento[]|ObjectCollection findByDataFim(string $data_fim) Return ChildOrcamento objects filtered by the data_fim column
 * @method     ChildOrcamento[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OrcamentoQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Table\Model\Base\OrcamentoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Table\\Model\\Orcamento', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrcamentoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrcamentoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOrcamentoQuery) {
            return $criteria;
        }
        $query = new ChildOrcamentoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrcamento|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrcamentoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrcamentoTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrcamento A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, prazo, data_inicio, data_fim FROM orcamento WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildOrcamento $obj */
            $obj = new ChildOrcamento();
            $obj->hydrate($row);
            OrcamentoTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildOrcamento|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrcamentoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrcamentoTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrcamentoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrcamentoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrcamentoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the prazo column
     *
     * Example usage:
     * <code>
     * $query->filterByPrazo(1234); // WHERE prazo = 1234
     * $query->filterByPrazo(array(12, 34)); // WHERE prazo IN (12, 34)
     * $query->filterByPrazo(array('min' => 12)); // WHERE prazo > 12
     * </code>
     *
     * @param     mixed $prazo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByPrazo($prazo = null, $comparison = null)
    {
        if (is_array($prazo)) {
            $useMinMax = false;
            if (isset($prazo['min'])) {
                $this->addUsingAlias(OrcamentoTableMap::COL_PRAZO, $prazo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prazo['max'])) {
                $this->addUsingAlias(OrcamentoTableMap::COL_PRAZO, $prazo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrcamentoTableMap::COL_PRAZO, $prazo, $comparison);
    }

    /**
     * Filter the query on the data_inicio column
     *
     * Example usage:
     * <code>
     * $query->filterByDataInicio('fooValue');   // WHERE data_inicio = 'fooValue'
     * $query->filterByDataInicio('%fooValue%'); // WHERE data_inicio LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dataInicio The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByDataInicio($dataInicio = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dataInicio)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dataInicio)) {
                $dataInicio = str_replace('*', '%', $dataInicio);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrcamentoTableMap::COL_DATA_INICIO, $dataInicio, $comparison);
    }

    /**
     * Filter the query on the data_fim column
     *
     * Example usage:
     * <code>
     * $query->filterByDataFim('fooValue');   // WHERE data_fim = 'fooValue'
     * $query->filterByDataFim('%fooValue%'); // WHERE data_fim LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dataFim The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByDataFim($dataFim = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dataFim)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dataFim)) {
                $dataFim = str_replace('*', '%', $dataFim);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrcamentoTableMap::COL_DATA_FIM, $dataFim, $comparison);
    }

    /**
     * Filter the query by a related \Table\Model\OrcamentoItem object
     *
     * @param \Table\Model\OrcamentoItem|ObjectCollection $orcamentoItem  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrcamentoQuery The current query, for fluid interface
     */
    public function filterByOrcamentoItem($orcamentoItem, $comparison = null)
    {
        if ($orcamentoItem instanceof \Table\Model\OrcamentoItem) {
            return $this
                ->addUsingAlias(OrcamentoTableMap::COL_ID, $orcamentoItem->getOrcamentoId(), $comparison);
        } elseif ($orcamentoItem instanceof ObjectCollection) {
            return $this
                ->useOrcamentoItemQuery()
                ->filterByPrimaryKeys($orcamentoItem->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrcamentoItem() only accepts arguments of type \Table\Model\OrcamentoItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrcamentoItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function joinOrcamentoItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrcamentoItem');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrcamentoItem');
        }

        return $this;
    }

    /**
     * Use the OrcamentoItem relation OrcamentoItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Table\Model\OrcamentoItemQuery A secondary query class using the current class as primary query
     */
    public function useOrcamentoItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrcamentoItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrcamentoItem', '\Table\Model\OrcamentoItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrcamento $orcamento Object to remove from the list of results
     *
     * @return $this|ChildOrcamentoQuery The current query, for fluid interface
     */
    public function prune($orcamento = null)
    {
        if ($orcamento) {
            $this->addUsingAlias(OrcamentoTableMap::COL_ID, $orcamento->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the orcamento table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrcamentoTableMap::clearInstancePool();
            OrcamentoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrcamentoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            OrcamentoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrcamentoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OrcamentoQuery
