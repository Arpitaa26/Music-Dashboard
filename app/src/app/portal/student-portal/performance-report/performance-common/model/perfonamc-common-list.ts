import { Perfonamccommon } from "../interface/perfonamccommon"
// import { PerfonamceCat } from "../interface/perfonamccommon"

export class PerfonamcCommonList {
  private static readonly performance_common1:Perfonamccommon = {
    heading:"Headding",
    category: [
        {
          heading:"Sub Heading 1",
          subcatCategory:[
            {
              name:"1",
              id:"1"
            },
            {
              name:"2",
              id:"z"
            },
            {
              name:"3",
              id:"zx"
            },
          ]
        },
        {
          heading:"Sub Heading 2",
          subcatCategory:[
            {
              name:"1",
              id:"1"
            },
            {
              name:"2",
              id:"z"
            },
            {
              name:"3",
              id:"zx"
            },
          ]
        }
    ]
  }
  public static get methPerfonamcCommonList(){
    return PerfonamcCommonList.performance_common1
  }
}
// {
//   name:'1',
//   id:'id1'
// },
// {
//   name:'1',
//   id:'id1'
// },
