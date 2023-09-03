import React from 'react';
import {createRoot} from 'react-dom/client';

import {NextUIProvider} from '@nextui-org/react';

const App = () => {
    return (
        <NextUIProvider>
            <h1>
                Hello World!
            </h1>
        </NextUIProvider>
    )
}


const container = document.getElementById('app');
const root = createRoot(container);
root.render(<App/>);


