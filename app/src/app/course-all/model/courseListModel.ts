import { AllCourseListInterface } from '../interface/courseListinterface';

export class CourseListModel {
  private static readonly AllCourseListObj: AllCourseListInterface[] = [
    {
      id: '1',
      courseName: 'Php',
      price: '500',
    },
    {
      id: '2',
      courseName: 'Php',
      price: '500',
    },
    {
      id: '3',
      courseName: 'Php',
      price: '500',
    },
    {
      id: '4',
      courseName: 'Php',
      price: '500',
    },
    {
      id: '5',
      courseName: 'Php',
      price: '500',
    },
  ];

  public static get returnMethod() {
    return CourseListModel.AllCourseListObj;
  }
}
