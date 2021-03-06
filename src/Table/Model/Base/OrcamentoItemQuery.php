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
use Table\Model\OrcamentoItem as ChildOrcamentoItem;
use Table\Model\OrcamentoItemQuery as ChildOrcamentoItemQuery;
use Table\Model\Map\OrcamentoItemTableMap;

/**
 * Base class that represents a query for the 'orcamento_item' table.
 *
 * 
 *
 * @method     ChildOrcamentoItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrcamentoItemQuery orderByOrcamentoId($order = Criteria::ASC) Order by the orcamento_id column
 * @method     ChildOrcamentoItemQuery orderByProduto($order = Criteria::ASC) Order by the produto column
 * @method     ChildOrcamentoItemQuery orderByQuantidade($order = Criteria::ASC) Order by the quantidade column
 * @method     ChildOrcamentoItemQuery orderByValor($order = Criteria::ASC) Order by the valor column
 *
 * @method     ChildOrcamentoItemQuery groupById() Group by the id column
 * @method     ChildOrcamentoItemQuery groupByOrcamentoId() Group by the orcamento_id column
 * @method     ChildOrcamentoItemQuery groupByProduto() Group by the produto column
 * @method     ChildOrcamentoItemQuery groupByQuantidade() Group by the quantidade column
 * @method     ChildOrcamentoItemQuery groupByValor() Group by the valor column
 *
 * @method     ChildOrcamentoItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrcamentoItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrcamentoItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrcamentoItemQuery leftJoinOrcamento($relationAlias = null) Adds a LEFT JOIN clause to the query using the Orcamento relation
 * @method     ChildOrcamentoItemQuery rightJoinOrcamento($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Orcamento relation
 * @method     ChildOrcamentoItemQuery innerJoinOrcamento($relationAlias = null) Adds a INNER JOIN clause to the query using the Orcamento relation
 *
 * @method     \Table\Model\OrcamentoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrcamentoItem findOne(ConnectionInterface $con = null) Return the first ChildOrcamentoItem matching the query
 * @method     ChildOrcamentoItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrcamentoItem matching the query, or a new ChildOrcamentoItem object populated from the query conditions when no match is found
 *
 * @method     ChildOrcamentoItem findOneById(int $id) Return the first ChildOrcamentoItem filtered by the id column
 * @method     ChildOrcamentoItem findOneByOrcamentoId(int $orcamento_id) Return the first ChildOrcamentoItem filtered by the orcamento_id column
 * @method     ChildOrcamentoItem findOneByProduto(string $produto) Return the first ChildOrcamentoItem filtered by the produto column
 * @method     ChildOrcamentoItem findOneByQuantidade(string $quantidade) Return the first ChildOrcamentoItem filtered by the quantidade column
 * @method     ChildOrcamentoItem findOneByValor(string $valor) Return the first ChildOrcamentoItem filtered by the valor column
 *
 * @method     ChildOrcamentoItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOrcamentoItem objects based on current ModelCriteria
 * @method     ChildOrcamentoItem[]|ObjectCollection findById(int $id) Return ChildOrcamentoItem objects filtered by the id column
 * @method     ChildOrcamentoItem[]|ObjectCollection findByOrcamentoId(int $orcamento_id) Return ChildOrcamentoItem objects filtered by the orcamento_id column
 * @method     ChildOrcamentoItem[]|ObjectCollection findByProduto(string $produto) Return ChildOrcamentoItem objects filtered by the produto column
 * @method     ChildOrcamentoItem[]|ObjectCollection findByQuantidade(string $quantidade) Return ChildOrcamentoItem objects filtered by the quantidade column
 * @method     ChildOrcamentoItem[]|ObjectCollection findByValor(string $valor) Return ChildOrcamentoItem objects filtered by the valor column
 * @method     ChildOrcamentoItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OrcamentoItemQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Table\Model\Base\OrcamentoItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Table\\Model\\OrcamentoItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrcamentoItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrcamentoItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOrcamentoItemQuery) {
            return $criteria;
        }
        $query = new ChildOrcamentoItemQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $orcamento_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrcamentoItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrcamentoItemTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrcamentoItemTableMap::DATABASE_NAME);
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
     * @return ChildOrcamentoItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, orcamento_id, produto, quantidade, valor FROM orcamento_item WHERE id = :p0 AND orcamento_id = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildOrcamentoItem $obj */
            $obj = new ChildOrcamentoItem();
            $obj->hydrate($row);
            OrcamentoItemTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildOrcamentoItem|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(OrcamentoItemTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(OrcamentoItemTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrcamentoItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrcamentoItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrcamentoItemTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the orcamento_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrcamentoId(1234); // WHERE orcamento_id = 1234
     * $query->filterByOrcamentoId(array(12, 34)); // WHERE orcamento_id IN (12, 34)
     * $query->filterByOrcamentoId(array('min' => 12)); // WHERE orcamento_id > 12
     * </code>
     *
     * @see       filterByOrcamento()
     *
     * @param     mixed $orcamentoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByOrcamentoId($orcamentoId = null, $comparison = null)
    {
        if (is_array($orcamentoId)) {
            $useMinMax = false;
            if (isset($orcamentoId['min'])) {
                $this->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $orcamentoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orcamentoId['max'])) {
                $this->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $orcamentoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $orcamentoId, $comparison);
    }

    /**
     * Filter the query on the produto column
     *
     * Example usage:
     * <code>
     * $query->filterByProduto('fooValue');   // WHERE produto = 'fooValue'
     * $query->filterByProduto('%fooValue%'); // WHERE produto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $produto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByProduto($produto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($produto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $produto)) {
                $produto = str_replace('*', '%', $produto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrcamentoItemTableMap::COL_PRODUTO, $produto, $comparison);
    }

    /**
     * Filter the query on the quantidade column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantidade('fooValue');   // WHERE quantidade = 'fooValue'
     * $query->filterByQuantidade('%fooValue%'); // WHERE quantidade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $quantidade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByQuantidade($quantidade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($quantidade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $quantidade)) {
                $quantidade = str_replace('*', '%', $quantidade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrcamentoItemTableMap::COL_QUANTIDADE, $quantidade, $comparison);
    }

    /**
     * Filter the query on the valor column
     *
     * Example usage:
     * <code>
     * $query->filterByValor('fooValue');   // WHERE valor = 'fooValue'
     * $query->filterByValor('%fooValue%'); // WHERE valor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $valor The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($valor)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $valor)) {
                $valor = str_replace('*', '%', $valor);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrcamentoItemTableMap::COL_VALOR, $valor, $comparison);
    }

    /**
     * Filter the query by a related \Table\Model\Orcamento object
     *
     * @param \Table\Model\Orcamento|ObjectCollection $orcamento The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function filterByOrcamento($orcamento, $comparison = null)
    {
        if ($orcamento instanceof \Table\Model\Orcamento) {
            return $this
                ->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $orcamento->getId(), $comparison);
        } elseif ($orcamento instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrcamentoItemTableMap::COL_ORCAMENTO_ID, $orcamento->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrcamento() only accepts arguments of type \Table\Model\Orcamento or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Orcamento relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function joinOrcamento($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Orcamento');

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
            $this->addJoinObject($join, 'Orcamento');
        }

        return $this;
    }

    /**
     * Use the Orcamento relation Orcamento object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Table\Model\OrcamentoQuery A secondary query class using the current class as primary query
     */
    public function useOrcamentoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrcamento($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Orcamento', '\Table\Model\OrcamentoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrcamentoItem $orcamentoItem Object to remove from the list of results
     *
     * @return $this|ChildOrcamentoItemQuery The current query, for fluid interface
     */
    public function prune($orcamentoItem = null)
    {
        if ($orcamentoItem) {
            $this->addCond('pruneCond0', $this->getAliasedColName(OrcamentoItemTableMap::COL_ID), $orcamentoItem->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(OrcamentoItemTableMap::COL_ORCAMENTO_ID), $orcamentoItem->getOrcamentoId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the orcamento_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrcamentoItemTableMap::clearInstancePool();
            OrcamentoItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrcamentoItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrcamentoItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            OrcamentoItemTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrcamentoItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OrcamentoItemQuery
