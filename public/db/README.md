返回值约定 ：{"status":1,"msg":"msg","data":[]}

其中status约定

1：代表成功

-1：前端输入错误

0：服务器问题

302：需要跳转，地址由data提供或者主动获取

302说明：如果data存在path字段,则主动跳转，否则请求url获取，302的data应该包括type(跳转类型:push,go)、url(url地址)、alert(弹窗类型:alert，confirm，none)字段
