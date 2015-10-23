<?php
/**
 * Since Baum hasn't come up with their own triat implementation, we can try to do so
 */

namespace Baum\Nestable;

interface Nestable{

	/**
	* Get the parent column name.
	*
	* @return string
	*/
	public function getParentColumnName();

	/**
	* Get the table qualified parent column name.
	*
	* @return string
	*/
	public function getQualifiedParentColumnName();

	/**
	* Get the value of the models "parent_id" field.
	*
	* @return int
	*/
	public function getParentId();

	/**
	 * Get the "left" field column name.
	 *
	 * @return string
	 */
	public function getLeftColumnName();

	/**
	 * Get the table qualified "left" field column name.
	 *
	 * @return string
	 */
	public function getQualifiedLeftColumnName();

	/**
	 * Get the value of the model's "left" field.
	 *
	 * @return int
	 */
	public function getLeft();

	/**
	 * Get the "right" field column name.
	 *
	 * @return string
	 */
	public function getRightColumnName();

	/**
	 * Get the table qualified "right" field column name.
	 *
	 * @return string
	 */
	public function getQualifiedRightColumnName();

	/**
	 * Get the value of the model's "right" field.
	 *
	 * @return int
	 */
	public function getRight();

	/**
	 * Get the "depth" field column name.
	 *
	 * @return string
	 */
	public function getDepthColumnName();

	/**
	 * Get the table qualified "depth" field column name.
	 *
	 * @return string
	 */
	public function getQualifiedDepthColumnName();

	/**
	 * Get the model's "depth" value.
	 *
	 * @return int
	 */
	public function getDepth();

	/**
	 * Get the "order" field column name.
	 *
	 * @return string
	 */
	public function getOrderColumnName();

	/**
	 * Get the table qualified "order" field column name.
	 *
	 * @return string
	 */
	public function getQualifiedOrderColumnName();

	/**
	 * Get the model's "order" value.
	 *
	 * @return mixed
	 */
	public function getOrder();

	/**
	 * Get the column names which define our scope
	 *
	 * @return array
	 */
	public function getScopedColumns();

	/**
	 * Get the qualified column names which define our scope
	 *
	 * @return array
	 */
	public function getQualifiedScopedColumns();

	/**
	 * Returns wether this particular node instance is scoped by certain fields
	 * or not.
	 *
	 * @return boolean
	 */
	public function isScoped();

	/**
	* Parent relation (self-referential) 1-1.
	*
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
	public function parent();

	/**
	* Children relation (self-referential) 1-N.
	*
	* @return \Illuminate\Database\Eloquent\Relations\HasMany
	*/
	public function children();

	/**
	 * Get a new "scoped" query builder for the Node's model.
	 *
	 * @param  bool  $excludeDeleted
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public function newNestedSetQuery($excludeDeleted = true);

	/**
	 * Overload new Collection
	 *
	 * @param array $models
	 * @return \Baum\Extensions\Eloquent\Collection
	 */
	public function newCollection(array $models = array());

	/**
	 * Get all of the nodes from the database.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function all($columns = array('*'));

	/**
	 * Returns the first root node.
	 *
	 * @return NestedSet
	 */
	public static function root();

	/**
	 * Static query scope. Returns a query scope with all root nodes.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public static function roots();

	/**
	 * Static query scope. Returns a query scope with all nodes which are at
	 * the end of a branch.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public static function allLeaves();

	/**
	 * Static query scope. Returns a query scope with all nodes which are at
	 * the middle of a branch (not root and not leaves).
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public static function allTrunks();

	/**
	 * Checks wether the underlying Nested Set structure is valid.
	 *
	 * @return boolean
	 */
	public static function isValidNestedSet();

	/**
	 * Rebuilds the structure of the current Nested Set.
	 *
	 * @param  bool $force
	 * @return void
	 */
	public static function rebuild($force = false);

	/**
	 * Maps the provided tree structure into the database.
	 *
	 * @param   array|\Illuminate\Support\Contracts\ArrayableInterface
	 * @return  boolean
	 */
	public static function buildTree($nodeList);

	/**
	 * Query scope which extracts a certain node object from the current query
	 * expression.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeWithoutNode($query, $node);

	/**
	 * Extracts current node (self) from current query expression.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeWithoutSelf($query);

	/**
	 * Extracts first root (from the current node p-o-v) from current query
	 * expression.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeWithoutRoot($query);

	/**
	 * Provides a depth level limit for the query.
	 *
	 * @param   query   \Illuminate\Database\Query\Builder
	 * @param   limit   integer
	 * @return  \Illuminate\Database\Query\Builder
	 */
	public function scopeLimitDepth($query, $limit);

	/**
	 * Returns true if this is a root node.
	 *
	 * @return boolean
	 */
	public function isRoot();

	/**
	 * Returns true if this is a leaf node (end of a branch).
	 *
	 * @return boolean
	 */
	public function isLeaf();

	/**
	 * Returns true if this is a trunk node (not root or leaf).
	 *
	 * @return boolean
	 */
	public function isTrunk();

	/**
	 * Returns true if this is a child node.
	 *
	 * @return boolean
	 */
	public function isChild();

	/**
	 * Returns the root node starting at the current node.
	 *
	 * @return NestedSet
	 */
	public function getRoot();

	/**
	 * Instance scope which targes all the ancestor chain nodes including
	 * the current one.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function ancestorsAndSelf();

	/**
	 * Get all the ancestor chain from the database including the current node.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAncestorsAndSelf($columns = array('*'));

	/**
	 * Get all the ancestor chain from the database including the current node
	 * but without the root node.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAncestorsAndSelfWithoutRoot($columns = array('*'));

	/**
	 * Instance scope which targets all the ancestor chain nodes excluding
	 * the current one.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function ancestors();

	/**
	 * Get all the ancestor chain from the database excluding the current node.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAncestors($columns = array('*'));

	/**
	 * Get all the ancestor chain from the database excluding the current node
	 * and the root node (from the current node's perspective).
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAncestorsWithoutRoot($columns = array('*'));

	/**
	 * Instance scope which targets all children of the parent, including self.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function siblingsAndSelf();

	/**
	 * Get all children of the parent, including self.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getSiblingsAndSelf($columns = array('*'));

	/**
	 * Instance scope targeting all children of the parent, except self.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function siblings();

	/**
	 * Return all children of the parent, except self.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getSiblings($columns = array('*'));

	/**
	 * Instance scope targeting all of its nested children which do not have
	 * children.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function leaves();

	/**
	 * Return all of its nested children which do not have children.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getLeaves($columns = array('*'));

	/**
	 * Instance scope targeting all of its nested children which are between the
	 * root and the leaf nodes (middle branch).
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function trunks();

	/**
	 * Return all of its nested children which are trunks.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getTrunks($columns = array('*'));

	/**
	 * Scope targeting itself and all of its nested children.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function descendantsAndSelf();

	/**
	 * Retrieve all nested children an self.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getDescendantsAndSelf($columns = array('*'));

	/**
	 * Set of all children & nested children.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function descendants();

	/**
	 * Retrieve all of its children & nested children.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getDescendants($columns = array('*'));

	/**
	 * Set of "immediate" descendants (aka children), alias for the children relation.
	 *
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function immediateDescendants();

	/**
	 * Retrive all of its "immediate" descendants.
	 *
	 * @param array   $columns
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getImmediateDescendants($columns = array('*'));

	/**
	* Returns the level of this node in the tree.
	* Root level is 0.
	*
	* @return int
	*/
	public function getLevel();

	/**
	 * Returns true if node is a descendant.
	 *
	 * @param NestedSet
	 * @return boolean
	 */
	public function isDescendantOf($other);

	/**
	 * Returns true if node is self or a descendant.
	 *
	 * @param NestedSet
	 * @return boolean
	 */
	public function isSelfOrDescendantOf($other);

	/**
	 * Returns true if node is an ancestor.
	 *
	 * @param NestedSet
	 * @return boolean
	 */
	public function isAncestorOf($other);

	/**
	 * Returns true if node is self or an ancestor.
	 *
	 * @param NestedSet
	 * @return boolean
	 */
	public function isSelfOrAncestorOf($other);

	/**
	 * Returns the first sibling to the left.
	 *
	 * @return NestedSet
	 */
	public function getLeftSibling();

	/**
	 * Returns the first sibling to the right.
	 *
	 * @return NestedSet
	 */
	public function getRightSibling();

	/**
	 * Find the left sibling and move to left of it.
	 *
	 * @return \Baum\Node
	 */
	public function moveLeft();

	/**
	 * Find the right sibling and move to the right of it.
	 *
	 * @return \Baum\Node
	 */
	public function moveRight();

	/**
	 * Move to the node to the left of ...
	 *
	 * @return \Baum\Node
	 */
	public function moveToLeftOf($node);

	/**
	 * Move to the node to the right of ...
	 *
	 * @return \Baum\Node
	 */
	public function moveToRightOf($node);

	/**
	 * Alias for moveToRightOf
	 *
	 * @return \Baum\Node
	 */
	public function makeNextSiblingOf($node);

	/**
	 * Alias for moveToRightOf
	 *
	 * @return \Baum\Node
	 */
	public function makeSiblingOf($node);

	/**
	 * Alias for moveToLeftOf
	 *
	 * @return \Baum\Node
	 */
	public function makePreviousSiblingOf($node);

	/**
	 * Make the node a child of ...
	 *
	 * @return \Baum\Node
	 */
	public function makeChildOf($node);

	/**
	 * Make the node the first child of ...
	 *
	 * @return \Baum\Node
	 */
	public function makeFirstChildOf($node);

	/**
	 * Make the node the last child of ...
	 *
	 * @return \Baum\Node
	 */
	public function makeLastChildOf($node);

	/**
	 * Make current node a root node.
	 *
	 * @return \Baum\Node
	 */
	public function makeRoot();

	/**
	 * Equals?
	 *
	 * @param \Baum\Node
	 * @return boolean
	 */
	public function equals($node);

	/**
	 * Checkes if the given node is in the same scope as the current one.
	 *
	 * @param \Baum\Node
	 * @return boolean
	 */
	public function inSameScope($other);


	/**
	 * Checks wether the given node is a descendant of itself. Basically, whether
	 * its in the subtree defined by the left and right indices.
	 *
	 * @param \Baum\Node
	 * @return boolean
	 */
	public function insideSubtree($node);

	/**
	 * Sets default values for left and right fields.
	 *
	 * @return void
	 */
	public function setDefaultLeftAndRight();

	/**
	 * Store the parent_id if the attribute is modified so as we are able to move
	 * the node to this new parent after saving.
	 *
	 * @return void
	 */
	public function storeNewParent();

	/**
	 * Move to the new parent if appropiate.
	 *
	 * @return void
	 */
	public function moveToNewParent();

	/**
	 * Sets the depth attribute
	 *
	 * @return \Baum\Node
	 */
	public function setDepth();

	/**
	 * Sets the depth attribute for the current node and all of its descendants.
	 *
	 * @return \Baum\Node
	 */
	public function setDepthWithSubtree();

	/**
	 * Prunes a branch off the tree, shifting all the elements on the right
	 * back to the left so the counts work.
	 *
	 * @return void;
	 */
	public function destroyDescendants();

	/**
	 * "Makes room" for the the current node between its siblings.
	 *
	 * @return void
	 */
	public function shiftSiblingsForRestore();

	/**
	 * Restores all of the current node's descendants.
	 *
	 * @return void
	 */
	public function restoreDescendants();

	/**
	 * Return an key-value array indicating the node's depth with $seperator
	 *
	 * @return Array
	 */
	public static function getNestedList($column, $key = null, $seperator = ' ');

	  /**
   * Reloads the model from the database.
   *
   * @return \Baum\Node
   *
   * @throws ModelNotFoundException
   */
  public function reload();

  /**
   * Get the observable event names.
   *
   * @return array
   */
  public function getObservableEvents();

  /**
   * Register a moving model event with the dispatcher.
   *
   * @param  Closure|string  $callback
   * @return void
   */
  public static function moving($callback, $priority = 0);

  /**
   * Register a moved model event with the dispatcher.
   *
   * @param  Closure|string  $callback
   * @return void
   */
  public static function moved($callback, $priority = 0);

  /**
   * Returns wether soft delete functionality is enabled on the model or not.
   *
   * @return boolean
   */
  public function areSoftDeletesEnabled();

  /**
   * Static method which returns wether soft delete functionality is enabled
   * on the model.
   *
   * @return boolean
   */
  public static function softDeletesEnabled();
}
