import { Routes } from '@angular/router';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { PostListComponent } from '../app/components/posts/post-list.component';
import { PostComponent } from '../app/components/posts/form.component';

export const routes: Routes = [
    { path: '', component: PostListComponent },
    { path: 'new-post', component: PostComponent }
];


@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
  })

export class AppRoutingModule { }