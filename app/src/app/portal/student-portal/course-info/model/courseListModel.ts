import { CourseListInterface } from '../interface/courseListInterface';

export class CourseListModel {
  private static readonly CourseListObj: CourseListInterface[] = [
    {
      img: '../../../../../assets/img/pexels-pixabay-33597.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
    {
      img: '../../../../../assets/img/harmonium.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
    {
      img: '../../../../../assets/img/strings.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
    {
      img: '../../../../../assets/img/tabla.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
    {
      img: '../../../../../assets/img/trumpet.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
    {
      img: '../../../../../assets/img/violin.jpg',
      topHead: 'Lorem ipsum dolor sit, amet consectetur',
      author: 'Kritika Iyer',
    },
  ];

  public static get returnMethod() {
    return CourseListModel.CourseListObj;
  }
}
