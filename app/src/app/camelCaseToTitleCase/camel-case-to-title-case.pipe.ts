import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'camelCaseToTitleCase'
})
export class CamelCaseToTitleCasePipe implements PipeTransform {

  transform(value: string): string {
    // Split camel case string into words
    let words = value.split('_');

    // Capitalize the first letter of each word
    words = words.map(el => el.toLowerCase().charAt(0).toUpperCase() + el.slice(1).toLowerCase());

    // Join words with space
    return words.join(' ');
  }

}

@Pipe({
  name: 'camelCaseToTitleCaseTwo'
})
export class CamelCaseToTitleCaseTwoPipe implements PipeTransform {

  transform(value: string): string {
    // Split camel case string into words
    let words = value.split('_');

    // Capitalize the first letter of each word
    words = words.map(el => el.toLowerCase().charAt(0).toUpperCase() + el.slice(1).toLowerCase());

    // Join words with space
    return words.join(' ');
  }

}