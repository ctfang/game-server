# workermen 断点支持DEMO


## 使用

修改，用于把BusinessEvent更换，拦截信息，并推入xdebug队列
~~~~
BUSINESS_EVENT="\Apps\Events\DebugEvent"
~~~~
start.php文件按正确启动

xdebug.php由phpstorm启动

## 原理

因为xdebug断点会在stream_socket*系列函数结束；

原来的GatewayWorker和Register是基于端口通讯，端口通讯是基于stream_socket*系列函数；

通讯方式改成文件或其他方式，可以绕开xdebug冲突


xdebug.php是一个基于文件的小型队列（开发也足够了）
