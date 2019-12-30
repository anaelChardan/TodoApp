import {err, ok, Result} from './result';

const defaultInit: RequestInit = {
  credentials: 'include',
  referrerPolicy: 'same-origin',
};

export const fetchResult = async <T, E>(input: RequestInfo, init?: RequestInit): Promise<Result<T, E>> => {
  const response = await fetch(input, {
    ...defaultInit,
    ...init,
  });
  if (!response.ok) {
    return err<never, E>(await response.json());
  }

  if (204 === response.status) {
    return ok<T>((undefined as unknown) as T);
  }

  return ok<T>(await response.json());
};

const jsonRequest = async <T, E>(input: RequestInfo, method: string, init?: RequestInit): Promise<Result<T, E>> => {
  return fetchResult<T, E>(
    input,
    {
      method: method,
      headers:[['Content-type', 'application/json']],
      ...init,
      ...defaultInit
    }
  );
};

export const getJson = async <T, E>(input: RequestInfo, init?: RequestInit): Promise<Result<T, E>> => jsonRequest<T, E>(input, 'GET', init);
export const postJson = async <T, E>(input: RequestInfo, body: any, init?: RequestInit): Promise<Result<T, E>> => jsonRequest<T, E>(input, 'POST', {
  body: JSON.stringify(body)
});
