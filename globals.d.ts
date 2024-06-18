export {};

declare global {
  interface Window {
    graphWidget: {
      restUrl: string;
    };
  }
}