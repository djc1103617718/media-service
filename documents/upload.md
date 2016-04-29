# Upload服务设计

### 上传文件

文件内容通过POST二进制的方式的方式传输，附加参数通过URL传输。

```
POST http://upload.mp-media-service.app/{category_url_name}?name=xxx.jpg
```

### URI query parameters

| Name | Type | Description |
| ---- | ---- | ----------- |
| name | string | 名称 |
| description | string | 描述 |
| content_type | string | 自定义文件类型 |
| app_key | string | APP KEY |
| timestamp | integer | Unix时间戳(秒) |
| signature | string | 参数签名 |


### Response for successful upload

```
{
    "id": "XnOjxxljdl",
    "name": "xxx.jpg",
    "description": "Test Image",
    "content_type": "image/jpeg",
    "create_time": 1454292231,
    "update_time": 1454292231,
    "type": "image",
    "size": 12345,
    "url": "http://download.mp-media-service.app/{category_url_name}/{media_id}",
    "meta": {
        "width": 800,
        "height": 600,
        "latitude": 45.00000,
        "longitude": 180.0000
    }
}
```

### 开发流程

1. 模拟提交
2. 接收参数，处理文件流，求文件特征值，求文件类型
3. 文件重复性校验，提交S3，入库
4. 结合category进行文件合法性校验
5. 结合app进行身份合法性校验

