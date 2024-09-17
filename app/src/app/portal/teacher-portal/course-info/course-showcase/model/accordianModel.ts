import { AccordianInterface } from '../interface/accordianInterface';

export class AccordianModel {
  private static readonly AccordianListObj: AccordianInterface[] = [
    {
      parentName: 'Parent 1',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 2',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },

        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 3',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 4',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '4. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 5',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '4. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '5. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 6',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 7',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '2. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '3. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 8',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 9',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
      ],
    },
    {
      parentName: 'Parent 10',
      propertyList: [
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
        {
          propertyName: '1. Lorem ipsum dolor sit amet ',
        },
      ],
    },
  ];

  public static get returnMethod() {
    return AccordianModel.AccordianListObj;
  }
}
