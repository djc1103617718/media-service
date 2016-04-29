# Download服务设计

### 下载文件

```
GET http://download.mp-media-service.app/{category_url_name}/{hashids(media_id)}
GET http://download.mp-media-service.app/{category_url_name}/{hashids(media_id)}?c={conveter_name}&p={params}
GET http://download.mp-media-service.app/{category_url_name}/{hashids(media_id)}?{convert_rule_alias}
```

```
GET http://download.mp-media-service.app/avatars/1OyndbgGn
GET http://download.mp-media-service.app/avatars/1OyndbgGn?c=image-view&p=thumbnail/1,100x200/format/jpg/q/80
GET http://download.mp-media-service.app/avatars/1OyndbgGn?large
```

### 接口规格

注意：接口规格不含任何空格与换行符，下列内容经过格式化以便阅读。
    

```
image-view/thumbnail/1,100x200
          /format/{format}
          /q/{quality}
```


### URI query parameters

| Name | Type | Description | Default |
| ---- | ---- | ----------- | ------- |
| thumbnail | string | 缩略图参数 |  |
| format | string | 格式转换 | 原图格式  |
| q | integer | 图片质量取值 [1, 100] | 75 | 



| 模式 | 说明 |
| ---- | ----------- |
| 1,100x200 | 根据宽比例(原图宽:100)等比缩略 |
| 2,100x200 | 根据高比例(原图高:200)等比缩略 |
| 3,100x200 | 给出固定尺寸(100x200)强制缩略 |


###### 格式转换 {format} 和图片质量 {q} 参数：

| 参数名 | 说明 |
| ---- | ----------- |
| /thumbnail/{thumbnail} | <ul><li>新图缩略格式,如: 1,100x200</li><li>1: 缩略图模式，100x200: 缩略图宽高</li></ul>|
| /format/{format} | <ul><li>新图的输出格式</li><li>取值范围：jpg，gif，png，webp等，缺省为原图格式。</li></ul>|
| /q/{quality} | <ul><li>新图的图片质量</li><li>取值范围是[1, 100]，默认75。</li><li>原图质量算出一个修正值，取修正值和指定值中的小值</li></ul>|



七牛文档    http://developer.qiniu.com/docs/v6/api/reference/fop/image/imageview2.html



