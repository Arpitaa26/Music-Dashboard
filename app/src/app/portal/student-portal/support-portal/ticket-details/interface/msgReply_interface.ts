export interface MessageReply {
  time: string;
  title: string;
  message: string;
}
export interface ReplyData extends MessageReply {
  reply: ReplyDataObj[];
}

export interface ReplyDataObj {
  replyDat: string;
}
