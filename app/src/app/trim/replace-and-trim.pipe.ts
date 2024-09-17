import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'replaceAndTrim'
})
export class ReplaceAndTrimPipe implements PipeTransform {

  transform(value: string): string {
    return value.replace(/\n/g, ' ').trim(); // Replace line breaks with spaces and trim
  }

}
