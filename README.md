# redisGeoMatch
基于redis的geo方法实现距离范围内匹配

使用redis的Geo功能
- geoadd：添加地理位置的坐标
- geodist：计算两个位置之间的距离
- georadius：根据用户给定的经纬度坐标来获取指定范围内的地理位置集合
- geopos：获取地理位置的坐标
- georadiusbymember：根据储存在位置集合里面的某个地点获取指定范围内的地理位置集合
- geohash：返回一个或多个位置对象的 geohash 值
- zrem：删除指定数据

匹配满足条件的出发地和目的地，取交集即为满足条件的匹配。比如：
- C车源出发地n公里内匹配到的货源出发地为A，B，那么C1={A，B}
- C车源目的地n公里内匹配到的货源目的地为A，那么C2={A}
- 所以满足C车源的要求只有A，即C={A}