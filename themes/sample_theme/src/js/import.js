import Common from './pages/common';
import Top from './pages/top';

const init = () => {
  new Common();

  switch (document.body.dataset.pageKey) {
  case 'top':
    new Top();
    break;
  }
};

init();
