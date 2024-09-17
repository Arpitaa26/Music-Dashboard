import { DatePipe } from '@angular/common';
import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'customdate',
})
export class CustomdatePipe implements PipeTransform {
  transform(value: any): any {
    let newDate = new Date(value);
    // Convert the date from IST to UTC
    const utcDate = new Date(newDate.getTime() + 330 * 60 * 1000);

    // Convert the UTC date to the user's local time zone
    const localDate = new Date(
      utcDate.getTime() + utcDate.getTimezoneOffset() * 60 * 1000
    );

    // Return the local date
    return localDate;
  }


  // transform(value: any, args?: any): any {
  //   // // Convert the input date to UTC
  //   // const utcDate = new Date(value);
  //   // utcDate.setMinutes(utcDate.getMinutes() - utcDate.getTimezoneOffset());

  //   // // Format the date
  //   // const formattedDate = this.getFormattedDate(utcDate);

  //   // // Format the time
  //   // const formattedTime = super.transform(utcDate, 'hh:mm a');

  //   // return `${formattedDate} ${formattedTime}`;
  // }

  // private getFormattedDate(date: Date): string {
  //   // Array of month names
  //   const monthNames = ["January", "February", "March", "April", "May", "June",
  //                       "July", "August", "September", "October", "November", "December"];

  //   // Get day, month, and year
  //   const day = date.getDate();
  //   const month = monthNames[date.getMonth()];
  //   const year = date.getFullYear();

  //   return `${day} ${month} ${year}`;
  // }
}
@Pipe({
  name: 'customdatedate',
})
export class CustomdatedatePipe implements PipeTransform {
  transform(value: any): any {
    let newDate = new Date(value);
    // Convert the date from IST to UTC
    const utcDate = new Date(newDate.getTime() + 330 * 60 * 1000);

    // Convert the UTC date to the user's local time zone
    const localDate = new Date(
      utcDate.getTime() + utcDate.getTimezoneOffset() * 60 * 1000
    );

    // Return the local date
    return localDate;
  }

}

@Pipe({
  name: 'customdatedateforchat',
})
export class CustomdatedatePipechat implements PipeTransform {
  transform(value: any): any {
    let newDate = new Date(value);
    // Convert the date from IST to UTC
    const utcDate = new Date(newDate.getTime() + 330 * 60 * 1000);

    // Convert the UTC date to the user's local time zone
    const localDate = new Date(
      utcDate.getTime() + utcDate.getTimezoneOffset() * 60 * 1000
    );

    // Return the local date
    return localDate;
  }

}