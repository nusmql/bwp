(function(w){
	var rongConfig,
	userId,
	token,
	appKey = "e5t4ouvpersva",
	status=0,
	targetId; // 目标 Id

	function readyToConnect() {
		console.log(token);
		console.log(userId);
		console.log(appKey);


		RongIMClient.init(appKey);
	 // 设置连接监听状态 （ status 标识当前连接状态）
	 // 连接状态监听器
	 RongIMClient.setConnectionStatusListener({
	 	onChanged: function (status) {
	 		switch (status) {
	            //链接成功
	            case RongIMLib.ConnectionStatus.CONNECTED:
	            console.log('链接成功');
	            break;
	            //正在链接
	            case RongIMLib.ConnectionStatus.CONNECTING:
	            console.log('正在链接');
	            break;
	            //重新链接
	            case RongIMLib.ConnectionStatus.DISCONNECTED:
	            console.log('断开连接');
	            break;
	            //其他设备登录
	            case RongIMLib.ConnectionStatus.KICKED_OFFLINE_BY_OTHER_CLIENT:
	            console.log('其他设备登录');
	            break;
	              //网络不可用
	              case RongIMLib.ConnectionStatus.NETWORK_UNAVAILABLE:
	              console.log('网络不可用');
	              break;
	          }
	      }});

	 // 消息监听器
	 RongIMClient.setOnReceiveMessageListener({
	    // 接收到的消息
	    onReceived: function (message) {
	        // 判断消息类型
	        switch(message.messageType){
	        	case RongIMClient.MessageType.TextMessage:
	                   // 发送的消息内容将会被打印
	                console.log(message.content.content);
	                console.log(message.content);

					var html = '<div class="message">' +
								'<strong>[Receive from :' + message.senderUserId+ ']</strong>' +
								'<span>' + message.content.content + '</span>' +
								'</div>';
					$(".messages").append(html);

	                break;
	            case RongIMClient.MessageType.VoiceMessage:
	                // 对声音进行预加载                
	                // message.content.content 格式为 AMR 格式的 base64 码
	                RongIMLib.RongIMVoice.preLoaded(message.content.content);
	                break;
	            case RongIMClient.MessageType.ImageMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.DiscussionNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.LocationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.RichContentMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.DiscussionNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.InformationNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.ContactNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.ProfileNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.CommandNotificationMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.CommandMessage:
	                // do something...
	                break;
	            case RongIMClient.MessageType.UnknownMessage:
	                // do something...
	                break;
	            default:
	                // 自定义消息
	                console.log("defualt");
	                break;
	            }
	        }
	    });

		// connect to rong cloud	
		RongIMClient.connect(token, {
			onSuccess: function(userId) {
				status=1;

				console.log("Login successfully." + userId);

				//getHistoryMessages
				 RongIMClient.getInstance().getHistoryMessages(RongIMLib.ConversationType.PRIVATE, targetId, null, 20, {
				          onSuccess: function(list, hasMsg) {
				            // hasMsg为boolean值，如果为true则表示还有剩余历史消息可拉取，为false的话表示没有剩余历史消息可供拉取。
				               // list 为拉取到的历史消息列表
				              console.log(hasMsg);
				              console.log(list);
				          },
				          onError: function(error) {
				              // APP未开启消息漫游或处理异常
				                   // throw new ERROR ......
				          }
				});

			},
			onTokenIncorrect: function() {
				console.log('token无效');
			},
			onError:function(errorCode){
				var info = '';
				switch (errorCode) {
					case RongIMLib.ErrorCode.TIMEOUT:
					info = '超时';
					break;
					case RongIMLib.ErrorCode.UNKNOWN_ERROR:
					info = '未知错误';
					break;
					case RongIMLib.ErrorCode.UNACCEPTABLE_PaROTOCOL_VERSION:
					info = '不可接受的协议版本';
					break;
					case RongIMLib.ErrorCode.IDENTIFIER_REJECTED:
					info = 'appkey不正确';
					break;
					case RongIMLib.ErrorCode.SERVER_UNAVAILABLE:
					info = '服务器不可用';
					break;
				}
				console.log(errorCode);
			}
		});

	} // end of readyToConnect

	function onSendBtnClick(event) {
		
		if(status === 1) {
			var message = $("#text-message").val();

			var html = '<div class="message">' +
						'<strong>[From UserId:' +  userId + ']</strong>' +
						'<span>' + message + '</span>' +
						'</div>';
			$(".messages").append(html);
			$("#text-message").val('');

			 // 定义消息类型,文字消息使用 RongIMLib.TextMessage
			 var msg = new RongIMLib.TextMessage({content:message,extra:"附加信息"});
			 //或者使用RongIMLib.TextMessage.obtain 方法.具体使用请参见文档
			 //var msg = RongIMLib.TextMessage.obtain("hello");
			 var conversationtype = RongIMLib.ConversationType.PRIVATE; // 私聊


			 RongIMClient.getInstance().sendMessage(conversationtype, targetId, msg, {
			                // 发送消息成功
			                onSuccess: function (message) {
			                    //message 为发送的消息对象并且包含服务器返回的消息唯一Id和发送消息时间戳
			                    console.log("Send successfully");
			                },
			                onError: function (errorCode,message) {
			                	var info = '';
			                	switch (errorCode) {
			                		case RongIMLib.ErrorCode.TIMEOUT:
				                		info = '超时';
				                		break;
			                		case RongIMLib.ErrorCode.UNKNOWN_ERROR:
				                		info = '未知错误';
				                		break;
			                		case RongIMLib.ErrorCode.REJECTED_BY_BLACKLIST:
				                		info = '在黑名单中，无法向对方发送消息';
				                		break;
			                		case RongIMLib.ErrorCode.NOT_IN_DISCUSSION:
				                		info = '不在讨论组中';
				                		break;
			                		case RongIMLib.ErrorCode.NOT_IN_GROUP:
				                		info = '不在群组中';
				                		break;
			                		case RongIMLib.ErrorCode.NOT_IN_CHATROOM:
				                		info = '不在聊天室中';
				                		break;
			                		default :
				                		info = x;
				                		break;
			                	}
			                	console.log('发送失败:' + info);
			                }
			            }
			            );

			} else {
				console.log("connection got problem, cannot send");
			}
		}


		$(document).ready(function(){
		// assign the token
		rongConfig = w.rongConfig || {};
		console.log(rongConfig)

		if(rongConfig!== {}) {
			token = rongConfig.token;
			userId = rongConfig.userId;
			targetId = userId===2 ? '3':'2';
			readyToConnect();
		}

		$("#sendit").on('click', onSendBtnClick);
	})

		return {
		}

	})(window);