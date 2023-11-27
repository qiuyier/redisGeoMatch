<?php
// 连接redis
$redis = new Redis();
$redis->connect('127.0.0.1');

// 模拟货源出发坐标点数据
$redis->geoAdd('goods_start_coordinate', 121.361389, 31.115556, 'goods_id_' . 1);
$redis->geoAdd('goods_start_coordinate', 121.361389, 23.115556, 'goods_id_' . 2);
$redis->geoAdd('goods_start_coordinate', 121.361389, 24.115556, 'goods_id_' . 3);
$redis->geoAdd('goods_start_coordinate', 119.361389, 40.115556, 'goods_id_' . 4);
$redis->geoAdd('goods_start_coordinate', 131.361389, 46.115556, 'goods_id_' . 5);

// 模拟货源目的坐标点数据
$redis->geoAdd('goods_arrive_coordinate', 121.361389, 39.115556, 'goods_id_' . 1);
$redis->geoAdd('goods_arrive_coordinate', 112.361389, 25.115556, 'goods_id_' . 2);
$redis->geoAdd('goods_arrive_coordinate', 115.361389, 20.115556, 'goods_id_' . 3);
$redis->geoAdd('goods_arrive_coordinate', 109.361389, 32.115556, 'goods_id_' . 4);
$redis->geoAdd('goods_arrive_coordinate', 121.361389, 40.115556, 'goods_id_' . 5);
$redis->hSet('goods_id_2', 'car_type', 1);
$redis->hSet('goods_id_2', 'car_length', 6.8);

// 模拟车源出发和目的坐标点数据
$startLng = 121.650368;
$startLat = 22.797271;
$arriveLng = 111.265345;
$arriveLat = 26.221155;

// 计算车源出发地到目的地距离(仅为举例可以用geoDist方法算距离)
$redis->geoAdd('distance_pool', $startLng, $startLat, 'car_id_' . 1 . '_start');
$redis->geoAdd('distance_pool', $arriveLng, $arriveLat, 'car_id_' . 1 . '_arrive');
$oriDistance = $redis->geoDist('distance_pool', 'car_id_' . 1 . '_start', 'car_id_' . 1 . '_arrive', 'km');

// 获取以车源出发点为中心200km内满足的货源出发点数据 ['WITHCOORD']: 这是可选参数，表示要返回每个匹配的地理位置点的坐标
//$start = $redis->geoRadius('goods_start_coordinate', $startLng, $startLat, 200, 'km', ['WITHCOORD']);
$start = $redis->geoRadius('goods_start_coordinate', $startLng, $startLat, 200, 'km');

// 获取以车源目的点为中心200km内满足的货源目的点数据
$arrive = $redis->geoRadius('goods_arrive_coordinate', $arriveLng, $arriveLat, 200, 'km');

// 取交集，即为匹配中的货源信息
$match = array_intersect($start, $arrive);

// 删除指定经纬度
$redis->zRem('goods_arrive_coordinate','goods_id_' . 1,'goods_id_' . 2);