import { ReplyData } from '../interface/msgReply_interface';

export class MsgReplyModel {
  private static readonly MsgReplyModelObj: ReplyData[] = [
    {
      time: '2023-06-06 12:47:25',
      title: 'Something',
      message: 'Query Not Solved ?',
      reply: [
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
      ],
    },
    {
      time: '2023-06-06 12:47:25',
      title: 'Something',
      message: 'Query Not Solved ?',
      reply: [
        {
          replyDat: 'lorem ipsum dolor Sit',
        },

        {
          replyDat: 'lorem ipsum dolor Sit',
        },
      ],
    },
    {
      time: '2023-06-06 12:47:25',
      title: 'Something',
      message: 'Query Not Solved ?',
      reply: [
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
      ],
    },
    {
      time: '2023-06-06 12:47:25',
      title: 'Something',
      message: 'Query Not Solved ?',
      reply: [
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit',
        },
        {
          replyDat: 'lorem ipsum dolor Sit jhashhdhsjdah',
        },
      ],
    },
  ];

  public static get returnMethod() {
    return MsgReplyModel.MsgReplyModelObj;
  }
}
