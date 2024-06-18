import * as React from 'react';
import { createRoot } from '@wordpress/element';
import App from './app';
import './main.css';

const domNode = document.getElementById( 'graph_widget_render' ) as HTMLElement;
const root = createRoot( domNode );

root.render( <App /> );
