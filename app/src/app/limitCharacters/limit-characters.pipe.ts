import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'limitCharacters'
})
export class LimitCharactersPipe implements PipeTransform {

  transform(value: string, maxLength: number): string {
    if (value.length > maxLength) {
      return value.substring(0, maxLength) + '...';
    } else {
      return value;
    }
  }

}


@Pipe({
  name: 'limitCharactersTwo'
})
export class LimitCharactersTwoPipe implements PipeTransform {

  transform(value: string, maxLength: number): string {
    if (value.length > maxLength) {
      return value.substring(0, maxLength) + '...';
    } else {
      return value;
    }
  }

}
