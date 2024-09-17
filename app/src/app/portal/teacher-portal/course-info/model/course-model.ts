import { CourseList } from '../interface/course-interface';

export class CourseListModel {
  private static readonly CourseListObj: CourseList[] = [
    {
      id: '1',
      name: 'Php web Dev',
      description: 'desc',
      price: 500,
    },
    {
      id: '2',
      name: 'Angular',
      description: 'desc',
      price: 500,
    },
    {
      id: '3',
      name: 'React',
      description: 'desc',
      price: 500,
    },
    {
      id: '4',
      name: 'Node js',
      description: 'desc',
      price: 500,
    },
  ];

  public static get returnMethod() {
    return CourseListModel.CourseListObj;
  }
}
