import { Routes } from '@angular/router';
import { PostListComponent } from '../app/components/posts/post-list.component';
import { PostFormComponent } from '../app/components/posts/form.component';

export const routes: Routes = [
    { path: '', component: PostListComponent },
    { path: 'new-post', component: PostFormComponent }
];

export class AppRoutingModule { }