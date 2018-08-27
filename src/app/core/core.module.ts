import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { LayoutComponent } from './ui/layout/layout.component';
import { HeaderComponent } from './ui/header/header.component';
import { FooterComponent } from './ui/footer/footer.component';

import { HomeComponent } from './components/home/home.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [
    LayoutComponent, 
    HeaderComponent, 
    FooterComponent, HomeComponent
  ],
  exports: [
    LayoutComponent
  ]
})
export class CoreModule { }
