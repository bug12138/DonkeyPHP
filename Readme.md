# DonkeyPHP #

> 初始版本 V1.0


### 框架进度说明 ###

1. 完成入口文件的开发
2. 初步的mvc可以调用
3. model层处于半开发状态，待修改


### 2016/09/01 ###

1. 添加composer支持
2. 添加第三方库symfony/var-dumper,filp/whools

### 版本 V1.0.1 ###

1.确定自己写Model类 采用ORM模式 Model使用文档基本完成
    
	`   // 测试Model 范例1 更新其中一种方式
        $documents = Documents::findOne(["title" => "zzz111"]);
        $documents->title = "22222";
        $documents->update();
        // 更新第二种方式(集体更新)
        Documents::updateAll(['content' => 'test' ], ['title' => 2]);
        // 更新第三种方式
        $documents = Documents::findOne(["content" => "test"]);
        $documents->title = "22222";
        $documents->save();
        // 新增
        $docObject = new Documents();
        $docObject->title = 'zzz111';
        $docObject->save();
        // 删除第一种方式(集体)
        Documents::deleteAll(['title' => 'zzz111']);
        // 删除第二种方式
        $documents = Documents::findOne(["title" => "22222"]);
        $documents->delete();

        // 测试Model 范例1 查找这里用了yield协程、生成器
        $documents = Documents::findAll(['group_id' => 2]);
        // 单个查找，生成对象返回
        $documents = Documents::findOne(['group_id' => 2]);

        // 开启事务，想法是Donkey::getDb()
        Donkey::getDb()->beginTransaction();
        $docObject = new Documents();
        $docObject->title = 'eee222';
        $docObject->save();
        //Donkey::getDb()->rollBack();
        Donkey::getDb()->commit();`
2.优化类的命名和大小写问题

	donkey => Donkey
	model  => Model
	log    => Log

### 接下来的要做的东西

1. 添加是视图模板 待确定是否用 twig/twig



