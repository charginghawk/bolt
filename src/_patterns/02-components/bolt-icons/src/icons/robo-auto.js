// import { Preact, h } from 'preact';
const RoboAuto = ({ color, size, ...otherProps }) => {
  color = color || 'currentColor';
  size = size || '24';
  return (
    <svg width="32" height="32" viewBox="0 0 32 32" {...otherProps}>
      <title>Icon/product/Platform/Robo-auto</title>
      <path
        d="M20.031 15h2v-2h-2v2zm0-4h-2v6h6v-6h-4zM9.969 15h2v-2h-2v2zm4 2v-6h-6v6h6zm-3 6h10.063v-2H10.969v2zm17.094 0c0 .834-.292 1.542-.875 2.125a2.892 2.892 0 0 1-2.125.875H7a2.889 2.889 0 0 1-2.125-.875A2.889 2.889 0 0 1 4 23V9c0-.833.291-1.54.875-2.125A2.893 2.893 0 0 1 7 6h18.063c.833 0 1.541.292 2.125.875.583.584.875 1.292.875 2.125v14zM12 30.152h8v-2h-8v2zm19.719-19.37a.897.897 0 0 0-.656-.282h-1V9c0-1.375-.491-2.552-1.469-3.532C27.614 4.49 26.438 4 25.063 4H17V2h1c.25 0 .479-.094.688-.282A.922.922 0 0 0 19 1a.925.925 0 0 0-.312-.719A1.006 1.006 0 0 0 18 .001h-4.062c-.25 0-.48.092-.688.28a.922.922 0 0 0-.312.72c0 .291.103.53.312.717.208.188.438.282.688.282h1v2H7c-1.375 0-2.553.49-3.531 1.468C2.489 6.448 2 7.625 2 9v1H1c-.667 0-1 .334-1 1v8c0 .667.333 1 1 1h1v3c0 1.375.489 2.552 1.469 3.531.978.98 2.156 1.47 3.531 1.47h3v4.151h12V28h3.063c1.375 0 2.551-.49 3.531-1.469.978-.979 1.469-2.156 1.469-3.53v-3h1c.25 0 .468-.095.656-.283a.9.9 0 0 0 .281-.656v-7.625a.9.9 0 0 0-.281-.656z"
        fill="currentColor"
        fill-rule="evenodd"
      />
    </svg>
  );
};
export default RoboAuto;