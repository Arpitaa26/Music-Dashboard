import { RequestMapper } from 'src/app/request-mapper';
import { Nav } from '../interface/nav';

export class Navs {
  // private static readonly _nav1: Nav = {
  //   name: 'Update Profile',
  //   link: '/update_profile',
  //   id: 'dummy1',
  //   type:'link'
  // };
  // private static readonly _nav2: Nav = {
  //   name: 'dummy Link2',
  //   link: '/dummy1',
  //   id: 'dummy1',
  //   type:'link'
  // };
  // private static readonly _logout: Nav = {
  //   name: 'logout',
  //   link: '/'+RequestMapper.LOGOUT,
  //   id: 'logout',
  //   type:'button'
  // };
  private static readonly _profile: Nav = {
    name: 'Profile',
    link:  'abc',
    id: 'profile',
    type:'image',
    image:"./assets/dummt_profile.png"
  };

  public static get navMethod(){
    return[
      // Navs._nav1,
      // Navs._nav2,
      // Navs._logout,
      Navs._profile,
    ]
  }
}
