import { CarouselInterface } from '../interface/carouselInterface';

export class CarouselModel {
  private static readonly CarouselListObj: CarouselInterface[] = [
    {
      imgSrc: '../../../../../../assets/img/harmonium.jpg',
    },
    {
      imgSrc: '../../../../../../assets/img/strings.jpg',
    },
    {
      imgSrc: '../../../../../../assets/img/tabla.jpg',
    },
  ];

  public static get returnMethod() {
    return CarouselModel.CarouselListObj;
  }
}
