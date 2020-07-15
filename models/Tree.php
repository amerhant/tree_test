<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $position
 * @property string|null $path
 * @property int|null $level
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'position', 'level'], 'integer'],
            ['position', 'in', 'range' => [0, 1]],
            ['position', 'unique', 'targetAttribute' => ['parent_id', 'position']],
            [['path'], 'string', 'max' => 12288],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'position' => 'Position',
            'path' => 'Path',
            'level' => 'Level',
        ];
    }

    public static function createLeaf($parent_id,$position)
    {
        if(!($parent = Tree::findOne($parent_id)))
        {
            return false;
        }

        $leaf = new Tree();
        $leaf->parent_id = $parent_id;
        $leaf->position = $position;
        $leaf->path = $parent->path;
        $leaf->level = ++$parent->level;

        if(!$leaf->save())
        {
            Yii::error($leaf->errors);
            return false;
        }

        $leaf->path .= '.'.$leaf->id;
        $leaf->save();

        return $leaf;

    }

    public static function seeder($parent_id, $level_stop = 5)
    {
        if(!($parent = Tree::findOne($parent_id)))
        {
            return false;
        }

        $queue = [$parent];

        while(Count($queue))
        {
            $parent = array_shift($queue);

            if(!$parent)
            {
                break;
            }

            if($parent->level < $level_stop-1)
            {
                array_push($queue, Tree::createLeaf($parent->id,0), Tree::createLeaf($parent->id,1));
            }
            else
            {
                Tree::createLeaf($parent->id,0);
                Tree::createLeaf($parent->id,1);
            }
        }

        return true;
    }

    public static function getDownItems($id)
    {
        if(!($item = Tree::findOne($id)))
        {
            return [];
        }

        return Tree::find()->where(['like', 'path', $item->path.'.%', false])->orderBy('level')->all();
    }

    public static function getUpItems($id)
    {
        if(!($item = Tree::findOne($id)))
        {
            return [];
        }

        $items = explode('.', $item->path);
        array_pop($items);
        return Tree::find()->where(['in', 'id', $items])->orderBy('level')->all();
    }
}