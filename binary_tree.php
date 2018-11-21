<?php

/**
 * 二叉树数据图
 *
 *        A
 *     B    C
 *   D  E  F  G
 *     I  H
 */

class Node
{
    public $data;
    public $left;
    public $right;

    public function __construct($data)
    {
        $this->data = $data;
    }
}

$char = 'nodeA';
$$char = new Node('A');
foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'] as $char) {
    $name = "node{$char}";
    $$name = new Node($char);
}

$nodeA->left = $nodeB;
$nodeA->right = $nodeC;
$nodeB->left = $nodeD;
$nodeB->right = $nodeE;
$nodeE->left = $nodeI;
$nodeC->left = $nodeF;
$nodeC->right = $nodeG;
$nodeF->left = $nodeH;

/**
 * 前序便利
 * @param Node $node
 */
function preOrder(Node $node) {
    echo $node->data;
    if ($node->left) preOrder($node->left);
    if ($node->right) preOrder($node->right);
}
echo 'pre order: ';
preOrder($nodeA);
echo "\n";

/**
 * 后序遍历
 * @param Node $node
 */
function postOrder(Node $node) {
    if ($node->left) postOrder($node->left);
    if ($node->right) postOrder($node->right);
    echo $node->data;
}
echo 'post order: ';
postOrder($nodeA);
echo "\n";

/**
 * 中序遍历
 * @param Node $node
 */
function inOrder(Node $node) {
    if ($node->left) inOrder($node->left);
    echo $node->data;
    if ($node->right) inOrder($node->right);
}
echo 'in order: ';
inOrder($nodeA);
echo "\n";

/**
 * 层序遍历
 * 借助队列，节点出队的时候，把自己的左右子节点入队
 * @param Node $node
 */
function levelOrder(Node $node) {
    $queue = [];
    array_unshift($queue, $node);

    while ($queue) {
        $node = array_pop($queue);
        echo $node->data;
        if ($node->left) array_unshift($queue, $node->left);
        if ($node->right) array_unshift($queue, $node->right);
    }
}
echo 'level order: ';
levelOrder($nodeA);
echo "\n";

/**
 * 非递归方式前序遍历
 * 借助栈，出栈的时候打印自己，并把自己的右子节点和左子节点入栈
 * @param Node $node
 */
function preOrderX(Node $node) {
    $stack = [];
    array_unshift($stack, $node);
    while ($stack) {
        $node = array_shift($stack);
        echo $node->data;
        if ($node->right) array_unshift($stack, $node->right);
        if ($node->left) array_unshift($stack, $node->left);
    }
}
echo 'pre order without recursion: ';
preOrderX($nodeA);
echo "\n";

/**
 * 非递归方式后序遍历
 * 借助栈，一路向左入栈，然后出栈访问元素内容，并处理栈顶的右元素
 * @param Node $node
 */
function postOrderX(Node $node) {
    $stack = [];
    while ($node || $stack) {
        while ($node) {
            array_unshift($stack, $node);
            $node = $node->left;
        }
        $node = array_shift($stack);
        echo $node->data;
        if ($stack && $stack[0]->left === $node) {
            $node = $stack[0]->right;
        } else {
            $node = null;
        }
    }
}
echo 'post order without recursion: ';
postOrderX($nodeA);
echo "\n";

/**
 * 非递归方式中序遍历
 * 借助栈，一路向左入栈，然后出栈访问元素内容，指定下个节点是右节点或继续出栈
 * @param Node $node
 */
function inOrderX(Node $node) {
    $stack = [];

    while ($node || $stack) {
        while ($node) {
            array_unshift($stack, $node);
            $node = $node->left;
        }
        $node = array_shift($stack);
        echo $node->data;

        if ($node->right) {
            $node = $node->right;
        } else {
            $node = null;
        }
    }
}
echo 'in order without recursion: ';
inOrderX($nodeA);
echo "\n";
