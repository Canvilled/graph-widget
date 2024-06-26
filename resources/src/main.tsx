import * as React from 'react';
import { createRoot } from '@wordpress/element';
import App from './app';
import './main.css';

let domNode = document.getElementById('graph_widget_render');

if (domNode) {
    domNode = domNode as HTMLElement;
    const root = createRoot(domNode);
    root.render(<App />);
}